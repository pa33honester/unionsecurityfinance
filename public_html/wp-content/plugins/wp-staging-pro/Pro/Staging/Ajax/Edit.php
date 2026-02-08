<?php

namespace WPStaging\Pro\Staging\Ajax;

use Throwable;
use WPStaging\Framework\Component\AbstractTemplateComponent;
use WPStaging\Framework\TemplateEngine\TemplateEngine;
use WPStaging\Framework\Utils\Sanitize;
use WPStaging\Staging\Dto\StagingSiteDto;
use WPStaging\Staging\Sites;

class Edit extends AbstractTemplateComponent
{
    /** @var Sites */
    private $sites;

    /** @var Sanitize */
    private $sanitize;

    public function __construct(Sites $sites, Sanitize $sanitize, TemplateEngine $templateEngine)
    {
        parent::__construct($templateEngine);
        $this->sites    = $sites;
        $this->sanitize = $sanitize;
    }

    public function ajaxModalContent()
    {
        if (!$this->canRenderAjax()) {
            wp_send_json_error('Invalid request.');
        }

        $cloneId = $this->sanitize->sanitizeString(isset($_POST['cloneId']) ? $_POST['cloneId'] : '');
        if (empty($cloneId)) {
            wp_send_json_error('Invalid request. Clone ID missing!');
        }

        try {
            wp_send_json_success($this->templateEngine->render('pro/staging/modal/edit-staging-site-modal-content.php', [
                'stagingSite' => $this->sites->getStagingSiteDtoByCloneId($cloneId),
                'cloneId'     => $cloneId
            ]));
        } catch (Throwable $ex) {
            wp_send_json_error($ex->getMessage());
        }
    }

    public function ajaxSave()
    {
        if (!$this->canRenderAjax()) {
            wp_send_json_error('Invalid request.');
        }

        $cloneId = $this->sanitize->sanitizeString(isset($_POST['cloneId']) ? $_POST['cloneId'] : '');
        if (empty($cloneId)) {
            wp_send_json_error('Invalid request. Clone ID missing!');
        }

        $stagingSites = $this->sites->tryGettingStagingSites();
        if (empty($stagingSites)) {
            wp_send_json_error('No staging sites found.');
        }

        if (!array_key_exists($cloneId, $stagingSites)) {
            wp_send_json_error('Invalid clone ID.');
        }

        $stagingSite = new StagingSiteDto();
        $stagingSite->hydrate($stagingSites[$cloneId]);

        $stagingSite->setCloneId($cloneId);
        $stagingSite->setCloneName($this->validatePostAndSanitizeString('cloneName'));
        $stagingSite->setDirectoryName(preg_replace("#\W+#", '-', strtolower($this->validatePostAndSanitizeString('directoryName'))));
        $stagingSite->setPath($this->validatePostAndSanitizeString('path'));
        $stagingSite->setUrl($this->validatePostAndSanitizeString('url'));
        $stagingSite->setPrefix($this->validatePostAndSanitizeString('prefix'));
        // external database access data
        $stagingSite->setDatabaseUser($this->validatePostAndSanitizeString('databaseUser'));
        $stagingSite->setDatabasePassword($this->validatePostAndSanitizePassword('databasePassword'));
        $stagingSite->setDatabaseDatabase($this->validatePostAndSanitizeString('databaseDatabase'));
        $stagingSite->setDatabaseServer($this->validatePostAndSanitizeString('databaseServer'));
        $stagingSite->setDatabasePrefix($this->validatePostAndSanitizeString('databasePrefix'));
        $stagingSite->setDatabaseSsl($this->validatePostAndSanitizeString('databaseSsl') === 'true');
        // Set some values if not present !
        $stagingSite->setOwnerId(empty($stagingSite->getOwnerId()) ? get_current_user_id() : $stagingSite->getOwnerId());
        $stagingSite->setDatetime(empty($stagingSite->getDatetime()) ? time() : $stagingSite->getDatetime());

        $stagingSites[$cloneId] = $stagingSite->toArray();

        $result = $this->sites->updateStagingSites($stagingSites);

        wp_send_json([
            'success' => $result,
            'data'    => $result ? esc_html__('Staging site updated successfully.', 'wp-staging') : esc_html__('Failed to update staging site.', 'wp-staging'),
        ]);
    }

    protected function validatePostAndSanitizeString(string $fieldName): string
    {
        return isset($_POST[$fieldName]) ? $this->sanitize->sanitizeString($_POST[$fieldName]) : '';
    }

    protected function validatePostAndSanitizePassword(string $fieldName): string
    {
        return isset($_POST[$fieldName]) ? $this->sanitize->sanitizePassword($_POST[$fieldName]) : '';
    }
}
