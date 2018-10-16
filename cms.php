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
				<tr>
					<td><a href="cms.php?page=5">Request CV</a></td>
				</tr>
			</table>
		</td>
		<td>
			<div id="content_container">
			<?php
				include 'Parsedown.php';

				// Initialize Parsedown
				$parser = new Parsedown();
				// Safe mode escapes the html tags (ignores html tags)
				$parser->setSafeMode(true);

				$cvFile = 'cv.txt';

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

				// Shows a CV input form
				function show_cv_form() {
					// Proper way would be POST but for simplicity use GET
					echo '
					<form action="cms.php" method="GET">
						<input type="hidden" name="page" value="5">
						<label>Email:</label>
						<input type="text" name="email">
						<input type="submit" value="Send">
					</form>
					';
				}

				// Attempts to send CV to the passed address and return
				// True if it succeed
				function mail_CV($receiverMail) {
					global $cvFile;

					if (!is_readable($cvFile)) {
						echo 'The CV is currently unavailabe';
						return;
					}

					$content = file_get_contents($cvFile);
					return mail($receiverMail, 'My CV', $content);
				}

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
					case 5:
						// If the email is not set just show the cv form
						$showCVForm = false;
						if (!isset($_GET['email'])) {
							$showCVForm = true;
						}
						else {
							$email = $_GET['email'];
							// Try to send the cv
							if (!mail_CV($email)) {
								// Something went wrong request the user to try
								// again
								echo 'There was a problem sending the CV mail!';
								$showCVForm = true;
							}
							else {
								// Email was sent successfully
								echo 'Thank you for your intrest!';
							}
						}

						if ($showCVForm) {
							show_cv_form();
						}
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
