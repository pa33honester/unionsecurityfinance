
  <?php
require_once("scripts/functions.php");

 ?>
<!Doctype html><html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Bank Name API for ACH/NACHA Routing Numbers</title>
		<meta name="viewport" content="w<?php echo$shortname ?>h=device-w<?php echo$shortname ?>h, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- Le styles -->
		<link href="/css/bootstrap.min.css" rel="stylesheet">
		<link href="/css/font-awesome.css" rel="stylesheet">
		<style>
			@media (min-width:980px) {
				body {
					padding-top: 60px;
				}
			}
			.navbar-inverse .brand {
				color:white;
				font-weight:bold;
				text-shadow: 2px 2px 0px #2E3E4E;
			}

			.navbar-inverse .navbar-inner {
				background: rgb(70,71,65);
				background: -moz-linear-gradient(top,  rgba(70,71,65,1) 0%, rgba(104,106,95,1) 100%);
				background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(70,71,65,1)), color-stop(100%,rgba(104,106,95,1)));
				background: -webkit-linear-gradient(top,  rgba(70,71,65,1) 0%,rgba(104,106,95,1) 100%);
				background: -o-linear-gradient(top,  rgba(70,71,65,1) 0%,rgba(104,106,95,1) 100%);
				background: -ms-linear-gradient(top,  rgba(70,71,65,1) 0%,rgba(104,106,95,1) 100%);
				background: linear-gradient(top,  rgba(70,71,65,1) 0%,rgba(104,106,95,1) 100%);
				filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#464741', endColorstr='#686a5f',GradientType=0 );
				/* old way: background-image: linear-gradient(to bottom, #464741, #686a5f); */
				border-color: #3f3f2f
    		}

    		.navbar-inverse .nav > li > a {
    			color: #ededcb;
    			text-shadow: 1px 1px 0px #2E3E4E;
    		}

    		/* fix for bootstrap incompatibility with maps */
    		img { max-width:none; }
		</style>

		<!-- Le fav and touch icons
		<link rel="shortcut icon" href="/favicon.ico">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="/apple-touch-icon-114-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="/apple-touch-icon-72-precomposed.png">
		<link rel="apple-touch-icon-precomposed" href="/apple-touch-icon-57-precomposed.png">
		-->
		<script src="/js/jquery-1.8.2.min.js"></script>
		<script src="/js/bootstrap.min.js"></script>
		
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>
	$(document).ready( function()
		{
			$("#lookup").click(function() { doLookup($("#rn").val()); });
			$("#example-form").submit(function() { return false; });
			$("#tryit").click(function() { $('#rn').val('122242597'); $('#lookup').click() });
		});

	function doLookup(rn)
	{
		$("#result").empty().text("Looking up " + rn + "...");
		$.ajax({
			url: "https://www.routingnumbers.info/api/name.json?rn=" + rn,
			dataType: 'jsonp',
			success: onLookupSuccess
		});
	}

	function onLookupSuccess(data)
	{
		var table = $("<table>").attr("class", "table table-bordered");
		table.append($("<tr>").append($("<th>").text("Results").attr("colspan", "2")));

		for (var member in data)
		{
			coltype = typeof data[member];

			table.append($("<tr>")
					.append($("<td>").text(member))
					.append($("<td>").text(data[member]))
					);
		}
		$("#result").empty().append(table);
	}
</script>

	</head>
	<body>

		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container">
					<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</a>
					<a class="brand" href="/index"><i class="icon-info-sign"></i> RoutingNumbers.Info</a>
					<div class="nav-collapse">
						<ul class="nav">
							<li class="xactive"><a href="/api/index">API</a></li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Browse <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><a href="/areacode/index">Area Code</a></li>
									<li><a href="/city/index">City</a></li>
									<li><a href="/name/index">Name</a></li>
									<li><a href="/prefix/index">Prefix</a></li>
									<li><a href="/state/index">State</a></li>
									<li><a href="/zipcode/index">Zip Code</a></li>
								</ul>
							</li>
							<li><a href="/search">Search</a></li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Support <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><a href="/support/contact">Contact</a></li>
									<li><a href="/support/credit">Credits</a></li>
									<li><a href="/support/report">Reports</a></li>
								</ul>
							</li>
							
						</ul>
						<div class="navbar-text pull-right">
							<!--Logged in as <a href="/security/index"></a>-->
						</div>
					</div><!--/.nav-collapse -->
				</div>
			</div>
		</div>	<!-- /navbar -->


		<div class="container">


	<div class="page-header">
		
		<h1>Bank Name API for ACH/NACHA Routing Numbers</h1>

		<div class="alert alert-danger">
			NOTE: on December 9, 2018, the Federal Reserve will remove the downloadable directory that this site depends on (see the
			<a href="http://app.frbcommunications.org/e/es.aspx?s=1064&e=177477&elq=fc86a92106f14a509fb730c5440489ba">official notification</a>).
			There will be no updates after that date.  If someone reading this would provide a download code, <a href="/support/contact">let me know</a>!
		</div>

	
		
	<a href="https://simpleshare.io/go?site=twitter&amp;url=http%3A%2F%2Fwww.routingnumbers.info%2Fapi%2Fname&amp;text=Bank+Name+API+for+ACH%2FNACHA+Routing+Numbers&amp;ga=UA-328425-11" alt="Share on Twitter" title="Share on Twitter"><img src="https://www.vectorlogo.zone/logos/twitter/twitter-tile.svg" style="height:24px;width24px;margin-right:6px;"></a>
		
	<a href="https://simpleshare.io/go?site=pinboard&amp;url=http%3A%2F%2Fwww.routingnumbers.info%2Fapi%2Fname&amp;text=Bank+Name+API+for+ACH%2FNACHA+Routing+Numbers&amp;ga=UA-328425-11" alt="Share on Pinboard" title="Share on Pinboard"><img src="https://www.vectorlogo.zone/logos/pinboard/pinboard-tile.svg" style="height:24px;width24px;margin-right:6px;"></a>
		
	<a href="https://simpleshare.io/go?site=googleplus&amp;url=http%3A%2F%2Fwww.routingnumbers.info%2Fapi%2Fname&amp;text=Bank+Name+API+for+ACH%2FNACHA+Routing+Numbers&amp;ga=UA-328425-11" alt="Share on Google+" title="Share on Google+"><img src="https://www.vectorlogo.zone/logos/google_plus/google_plus-tile.svg" style="height:24px;width24px;margin-right:6px;"></a>
		
	<a href="/cdn-cgi/l/email-protection#39064a4c5b535c5a4d047b585752127758545c12786970125f564b12787a711c0b7f77787a7178126b564c4d50575e12774c545b5c4b4a1f585449025b565d4004514d4d491c0a781c0b7f1c0b7f4e4e4e174b564c4d50575e574c545b5c4b4a1750575f561c0b7f5849501c0b7f5758545c17514d5455" alt="Share via email" title="Share via email"><img src="/images/email.svg" style="height:24px;width24px;margin-right:6px;"></a>
	
	</div>



	
		
	



<table class="table table-bordered" w<?php echo$shortname ?>h="100%">
	<tr>
		<th style="text-align:left;">Parameter</th>
		<th style="text-align:left;">Description</th>
	</tr>
	<tr>
		<td>rn</td>
		<td>routing number</td>
	</tr>
	<tr>
		<td>callback</td>
		<td>(optional) name of the JSONP callback function</td>
	</tr>
</table>

<h2>Example</h2>
<p>Try a <a href="javascript:void(0);" id="tryit">sample number</a>.  Use <b>View Source</b> to see the code!</p>

<div class="row">
	<div class="span4 offset4 well">
		<legend>Bank Data Lookup</legend>
		<form action="javascript:void(0);" class="" id="example-form" method="post">
			<fieldset>
				<div class="control-group">
					<label class="control-label" for="rn">Routing Number</label>
					<div class="controls">
						<input class="span4" id="rn" name="rn" placeholder="9-digit bank routing number" type="text" value="" />
					</div>
				</div>
				<div class="control-group">
					<button class="btn btn-primary" id="lookup">Get bank data</button>
				</div>
			</fieldset>
		</form>
		<div id="result"></div>
	</div>
</div>



				
				<!-- start adsense -->
				<div class="row">
					<div class="span12" style="text-align:center;margin-top:10px">
						<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script type="text/javascript"><!--
						google_analytics_uacct = "UA-328425-11";
						google_ad_client = "pub-6975096118196151";
						google_ad_slot = "5726938337";
						google_ad_slot = "6902360693";
						google_ad_w<?php echo$shortname ?>h = 728;
						google_ad_height = 90;
						//--></script>
						<script type="text/javascript"
						src="https://pagead2.googlesyndication.com/pagead/show_ads.js">
						</script>
					</div>
				</div>
				<!-- end adsense -->
				
		</div>	<!-- /container -->
		<!-- start analytics -->
		<script type="text/javascript">

		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-328425-11']);
		  _gaq.push(['_trackPageview']);

		  (function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();

		</script>
		<!-- end analytics -->
	</body>
</html>