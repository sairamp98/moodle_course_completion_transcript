# moodle_course_completion_transcript

## Moodle Plugin Installation Guide

## Overview

This guide provides step-by-step instructions for installing the plugin into your Moodle LMS. This plugin is an enhanced version of the completionstatus block plugin that has a button in the user details page which redirects to a transcript page that shows the progress of user in all the courses that he/she is enrolled into.

## Requirements

- **Moodle Version:** This plugin is compatible with Moodle [Version 4.0.1 and above].
- **PHP Version:** Ensure your server is running PHP [Version 7.4 or higher].
- **Database:** Compatible with MySQL, PostgreSQL, and other Moodle-supported databases.

## Installation Steps

### 1. Download the Plugin

1. Download the plugin's ZIP file from [GitHub](https://github.com/sairamp98/moodle_course_completion_transcript).
2. Alternatively, you can clone the repository using Git:

    ```bash
    git clone https://github.com/sairamp98/moodle_course_completion_transcript.git
    ```

### 2. Upload the Plugin

#### Option 1: Upload via Moodle Interface

1. Log in to your Moodle site as an administrator.
2. Navigate to `Site administration > Plugins > Install plugins`.
3. Upload the ZIP file you downloaded or cloned earlier.
4. Click on the "Install plugin from ZIP file" button.
5. Review the validation report to ensure there are no errors.

#### Option 2: Upload via FTP/SFTP

1. Extract the ZIP file.
2. Upload the extracted folder to the `/moodle/yourmoodlefolder/mod/` or `/moodle/yourmoodlefolder/local/` directory (depending on your plugin type) on your server using an FTP/SFTP client.
3. Ensure that the uploaded plugin folder has the correct permissions (typically 755).

### 3. Complete the Installation

1. After uploading, navigate to `Site administration > Notifications` in Moodle.
2. Moodle will detect the new plugin and prompt you to proceed with the installation.
3. Follow the on-screen instructions to complete the installation process.
4. Configure the plugin settings by navigating to `Site administration > Plugins > [Your Plugin Name] settings`.

### 4. Verify the Installation

1. After installation, go to `Site administration > Plugins > Plugins overview` to ensure the plugin is listed and enabled.
2. Test the plugin to ensure it functions as expected.

## Uninstallation

To uninstall the plugin:

1. Navigate to `Site administration > Plugins > Plugins overview`.
2. Find the plugin in the list and click on "Uninstall".
3. Follow the on-screen instructions to remove the plugin from your Moodle site.

## Troubleshooting

- **Common Issues:** If you encounter issues during installation, check the Moodle documentation or the plugin's support page for solutions.
- **Debugging:** Enable debugging in Moodle (`Site administration > Development > Debugging`) to get detailed error messages if something goes wrong.
- **Permissions:** Ensure that the plugin directory and files have the correct permissions (755 for directories, 644 for files).

## Contributing

If you'd like to contribute to the development of this plugin, please follow these steps:

1. Fork the repository on GitHub.
2. Create a new branch (`git checkout -b feature/your-feature`).
3. Commit your changes (`git commit -am 'Add your feature'`).
4. Push to the branch (`git push origin feature/your-feature`).
5. Create a new Pull Request.