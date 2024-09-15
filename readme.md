# OnboardingPackage

**OnboardingPackage** is a Laravel package that allows you to create customized onboarding flows for users, including dynamic questions, options, conditional messages, and flow control based on user responses. The package supports multiple languages using **Spatie Laravel Translatable** and integrates with the **FilamentPHP** admin panel for easy management.

## Table of Contents

- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
  - [Managing Questions and Options](#managing-questions-and-options)
  - [Defining Conditional Messages](#defining-conditional-messages)
  - [Controlling the Question Flow](#controlling-the-question-flow)
- [API Endpoints](#api-endpoints)
  - [Submit User Response](#submit-user-response)
  - [Get User Responses](#get-user-responses)
- [Usage Examples](#usage-examples)
- [License](#license)

## Installation

You can install the package via Composer:

```bash
composer require bamboleedigital/onboarding-package
```

After installation, publish the migration and configuration files:

```bash
php artisan vendor:publish --provider="BamboleeDigital\OnboardingPackage\Providers\OnboardingServiceProvider" --tag="migrations"
php artisan vendor:publish --provider="BamboleeDigital\OnboardingPackage\Providers\OnboardingServiceProvider" --tag="config"
```

Then, run the migrations:

```bash
php artisan migrate
```

## Configuration

### Filament and Spatie Laravel Translatable

Make sure that **FilamentPHP** and **Spatie Laravel Translatable** are installed and configured in your project.

Install the Filament translation plugin:

```bash
composer require filament/spatie-laravel-translatable-plugin:"^3.2" -W
```

Add the plugin to your Filament panel:

```php
use Filament\SpatieLaravelTranslatablePlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        // ...
        ->plugin(
            SpatieLaravelTranslatablePlugin::make()
                ->defaultLocales(['en', 'pt']), // Set the languages you want to support
        );
}
```

### Package Configuration

The package configuration file allows you to customize options as needed. The `config/onboarding-package.php` file will be published in the root of your project's `config` folder.

## Usage

### Managing Questions and Options

Access the FilamentPHP admin panel and navigate to the **Questions** menu.

#### Create a New Question

1. Click on **Create**.
2. Enter the **Question Text**. Use the `LocaleSwitcher` to add translations in different languages.
3. Select the **Question Type**:
   - **Text**: The user will provide a free-text answer.
   - **Single Choice**: The user will select one option.
   - **Multiple Choice**: The user can select multiple options.
4. Save the question.

#### Manage Options

For **Single Choice** or **Multiple Choice** questions:

1. Within the created question, access the **Options** tab.
2. Click **Create** to add a new option.
3. Enter the **Option Text** and translations, if applicable.
4. Optionally, add a **Conditional Message** in Markdown. This message will be displayed to the user if this option is selected.
5. Set the **Next Question** if you want to control the flow based on the user's response.
6. Save the option.

### Defining Conditional Messages

Conditional messages are directly associated with options. When adding a conditional message to an option, it will be displayed to the user when that option is selected.

### Controlling the Question Flow

You can define the next question the user will see after selecting a particular option:

1. In the option creation or editing form, select the **Next Question** in the corresponding field.
2. If no next question is defined, the system will follow the default order.

## API Endpoints

### Submit User Response

**URL:** `/api/onboarding/responses`

**Method:** `POST`

**Parameters:**

- `question_id` (integer, required): ID of the answered question.
- `response_id` (integer, optional): ID of the selected option (for choice questions).
- `response` (string, optional): User's response (for text questions).

**Request Example:**

```json
POST /api/onboarding/responses
Content-Type: application/json

{
  "question_id": 1,
  "response_id": 5,
  "user_id": 123
}
```

**Response Example:**

```json
{
  "next_question": {
    "id": 2,
    "text": "What is your age?",
    "type": "text",
    "options": []
  },
  "conditional_message": {
    "message": "Thank you for choosing this option. Here's a personalized message."
  }
}
```

### Get User Responses

**URL:** `/api/onboarding/user-responses`

**Method:** `GET`

**Parameters:**

- `user_id` (integer, required): User ID.

**Request Example:**

```
GET /api/onboarding/user-responses?user_id=123
```

**Response Example:**

```json
{
  "responses": [
    {
      "question_id": 1,
      "question_text": "What is your name?",
      "response": "John",
      "response_id": null,
      "option_text": null
    },
    {
      "question_id": 2,
      "question_text": "What is your favorite color?",
      "response": null,
      "response_id": 5,
      "option_text": "Blue"
    }
    // Other responses...
  ]
}
```

## Usage Examples

### Basic Onboarding Flow

1. The user starts the onboarding process.
2. The application consumes the endpoint to send the user's responses.
3. The backend returns the next question and any conditional messages.
4. The frontend displays the question and processes the user's response.
5. The flow continues until there are no more questions.

### Displaying Conditional Messages

- When the user selects an option with a conditional message, that message is returned in the API response and can be displayed immediately.

### Controlling the Flow Based on Responses

- By setting the **Next Question** on an option, you can direct the user to different paths in the onboarding flow, creating personalized experiences.

## License

The OnboardingPackage is licensed under the [MIT license](LICENSE.md).