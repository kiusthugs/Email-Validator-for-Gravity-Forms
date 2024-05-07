# Email Validator Plugin for WordPress

A WordPress plugin that integrates with the Email List Verify API to validate email addresses submitted through Gravity Forms.

## Description

This plugin adds email validation functionality to your WordPress website. It uses the Email List Verify API to verify email addresses submitted through Gravity Forms, ensuring that only valid email addresses are accepted.

## Features

- Validates email addresses submitted through Gravity Forms.
- Integrates with the Email List Verify API for accurate email validation.
- Provides settings page to input and save API key.
- Error handling for missing API key and API request failures.

## Installation

1. Download the plugin zip file.
2. Go to your WordPress admin dashboard.
3. Navigate to Plugins > Add New.
4. Click on the "Upload Plugin" button.
5. Choose the downloaded zip file and click "Install Now".
6. Once installed, activate the plugin.

## Usage

1. After activating the plugin, go to Settings > Email Validator.
2. Enter your Email List Verify API key and click "Save Changes".
3. Use Gravity Forms to create a form with an email field.
4. Submit the form with an email address to see the validation in action.

## Screenshots

![Settings Page](/screenshots/image%20(16).png)
*Settings Page: Enter your Email List Verify API key here.*

![Form Submission](/screenshots/image%20(17).png)
*Form Submission: Error message displayed for invalid email address.*

![No API Key Submission](/screenshots/image%20(15).png)
*No API Key Provided Submission: Error message displayed when API key is not provided.*

## Contributing

Contributions are welcome! If you find any bugs or have suggestions for improvement, please open an issue or submit a pull request.
