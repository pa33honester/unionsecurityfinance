<?php

/**
 * The command that will handle the creation of a Staging Site from the command line.
 *
 * @package WPStaging\Pro\WpCli\Commands
 */

namespace WPStaging\Pro\WpCli\Commands;

use WP_CLI;
use WPStaging\Core\WPStaging;
use WPStaging\Pro\Staging\BackgroundProcessing\PrepareCreate;

/**
 * Class StagingSiteCreateCommand
 *
 * @package WPStaging\Pro\WpCli\Commands
 */
class StagingSiteCreateCommand implements CommandInterface
{
    /**
     * Create the Staging Site using the Background Processing system.
     *
     * @param array               $args      A list of the positional arguments provided by the user, already validated.
     * @param array<string,mixed> $assocArgs A map of the associative arguments, options and flags, provided by the user.
     * @return mixed This method will return mixed values depending on the class that is invoked.
     * @throws WP_CLI\ExitException If the Job preparation fails, then a message will be provided to the user
     *                              detailing the reason.
     */
    public function __invoke(array $args = [], array $assocArgs = [])
    {
        $options = $this->extractOptionsFromArgs($args);
        $data = $this->setupStagingSiteCreateData($options);

        try {
            $jobId = WPStaging::make(PrepareCreate::class)->prepare($data);

            if ($jobId instanceof \WP_Error) {
                WP_CLI::error('Failed to prepare request for creating staging site: ' . $jobId->get_error_message());
            }

            $quiet = isset($assocArgs['quiet']);
            if (!$quiet) {
                WP_CLI::success(
                    sprintf(
                        "Staging Site creation with Job ID %s\nUse the \"%s\" command to check its status.",
                        $jobId,
                        "wp wpstg job-status '$jobId'"
                    )
                );
            } else {
                WP_CLI::line($jobId);
            }
        } catch (\Exception $e) {
            WP_CLI::error('Exception thrown while preparing the creation of staging site: ' . $e->getMessage());
        }
    }

    protected function extractOptionsFromArgs(array $args): array
    {
        $options = [];
        foreach ($args as $arg) {
            $parts = explode('=', $arg);
            if (count($parts) === 2) {
                $options[$parts[0]] = $parts[1];
            }
        }

        return $options;
    }

    protected function setupStagingSiteCreateData(array $options): array
    {
        $data = [
            'cloneId'             => time(),
            'allTablesExcluded'   => false,
            'excludedTables'      => [],
            'includedTables'      => [],
            'nonSiteTables'       => [],
            'excludedDirectories' => [],
            'extraDirectories'    => [],
            'excludeGlobRules'    => [],
        ];

        $data['isWpCliRequest'] = true;

        return $data;
    }
}
