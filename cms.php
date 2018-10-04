<head>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<table>
	<tr>
		<td>
			<table class="navigation_table">
				<tr>
					<td><a href="cms.php?page=0">Home</a></td>
				</tr>
				<tr>
					<td><a href="cms.php?page=1">UCC</a></td>
				</tr>
				<tr>
					<td><a href="cms.php?page=2">Personal</a></td>
				</tr>
				<tr>
					<td><a href="cms.php?page=3">About</a></td>
				</tr>
				<tr>
					<td><a href="cms.php?page=4">Contact</a></td>
				</tr>
			</table>
		</td>
		<td>
			<div id="content_container">
			<?php
				include 'Parsedown.php';

				// Attempts to load the content file
				function load_content($contentFile) {
					// Get the global reference to our parser
					global $parser;

					// If we can't read the file output the 'under review'
					// notice
					if (!is_readable($contentFile)) {
						echo 'Content currently under review';
						return;
					}

					// Get the content from the $contentFile
					$content = file_get_contents($contentFile);

					// Parse the markdown with Parsedown
					echo $parser->text($content);
				}

				// Initialize Parsedown
				$parser = new Parsedown();
				// Safe mode escapes the html tags (ignores html tags)
				$parser->setSafeMode(true);

				// If we have the page parameter we set the pageIndex to that
				// otherwise we set it to the 'home' page
				$pageIndex = $_GET['page'] ?? 0;

				// Load the requested file (default is home.txt)
				switch ($pageIndex) {
					case 0:
						load_content('home.txt');
						break;
					case 1:
						load_content('ucc.txt');
						break;
					case 2:
						load_content('personal.txt');
						break;
					case 3:
						load_content('about.txt');
						break;
					case 4:
						load_content('contact.txt');
						break;
					default:
						// If the page parameter is invalid we just show the user home page
						load_content('home.txt');
				}
			?>
			</div>
		</td>
	</tr>
</table>
