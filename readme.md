# OnboardingPackage

O **OnboardingPackage** é um pacote Laravel que permite criar fluxos de onboarding personalizados para usuários, incluindo perguntas dinâmicas, opções, mensagens condicionais e controle do fluxo com base nas respostas dos usuários. O pacote suporta múltiplos idiomas utilizando o **Spatie Laravel Translatable** e integra-se com o painel administrativo do **FilamentPHP** para gerenciamento fácil.

## Sumário

- [Instalação](#instalação)
- [Configuração](#configuração)
- [Uso](#uso)
  - [Gerenciando Perguntas e Opções](#gerenciando-perguntas-e-opções)
  - [Definindo Mensagens Condicionais](#definindo-mensagens-condicionais)
  - [Controlando o Fluxo de Perguntas](#controlando-o-fluxo-de-perguntas)
- [API Endpoints](#api-endpoints)
  - [Enviar Resposta do Usuário](#enviar-resposta-do-usuário)
  - [Obter Respostas do Usuário](#obter-respostas-do-usuário)
- [Exemplos de Uso](#exemplos-de-uso)
- [Licença](#licença)
- [Changelog](#changelog)

## Instalação

Você pode instalar o pacote via Composer:

```bash
composer require bamboleedigital/onboarding-package
```

Após a instalação, publique os arquivos de migração e configuração:

```bash
php artisan vendor:publish --provider="BamboleeDigital\OnboardingPackage\Providers\OnboardingServiceProvider" --tag="migrations"
php artisan vendor:publish --provider="BamboleeDigital\OnboardingPackage\Providers\OnboardingServiceProvider" --tag="config"
```

Em seguida, execute as migrações:

```bash
php artisan migrate
```

## Configuração

### Filament e Spatie Laravel Translatable

Certifique-se de que o **FilamentPHP** e o **Spatie Laravel Translatable** estão instalados e configurados em seu projeto.

Instale o plugin de tradução do Filament:

```bash
composer require filament/spatie-laravel-translatable-plugin:"^3.2" -W
```

Adicione o plugin ao seu painel do Filament:

```php
use Filament\SpatieLaravelTranslatablePlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        // ...
        ->plugin(
            SpatieLaravelTranslatablePlugin::make()
                ->defaultLocales(['en', 'pt']), // Defina os idiomas que deseja suportar
        );
}
```

### Configuração do Pacote

O arquivo de configuração do pacote permite que você personalize as opções conforme necessário. O arquivo `config/onboarding-package.php` será publicado na raiz da pasta `config` do seu projeto.

## Uso

### Gerenciando Perguntas e Opções

Acesse o painel administrativo do FilamentPHP e navegue até o menu **Perguntas**.

#### Criar uma Nova Pergunta

1. Clique em **Criar**.
2. Insira o **Texto da Pergunta**. Use o `LocaleSwitcher` para adicionar traduções em diferentes idiomas.
3. Selecione o **Tipo de Pergunta**:
   - **Texto**: O usuário fornecerá uma resposta em texto livre.
   - **Escolha Única**: O usuário selecionará uma opção.
   - **Escolha Múltipla**: O usuário poderá selecionar várias opções.
4. Salve a pergunta.

#### Gerenciar Opções

Para perguntas do tipo **Escolha Única** ou **Escolha Múltipla**:

1. Dentro da pergunta criada, acesse a aba **Opções**.
2. Clique em **Criar** para adicionar uma nova opção.
3. Insira o **Texto da Opção** e traduções, se aplicável.
4. Opcionalmente, adicione uma **Mensagem Condicional** em Markdown. Esta mensagem será exibida ao usuário se esta opção for selecionada.
5. Defina a **Próxima Pergunta**, se desejar controlar o fluxo com base na resposta do usuário.
6. Salve a opção.

### Definindo Mensagens Condicionais

As mensagens condicionais estão associadas diretamente às opções. Ao adicionar uma mensagem condicional a uma opção, ela será exibida ao usuário quando essa opção for selecionada.

### Controlando o Fluxo de Perguntas

Você pode definir a próxima pergunta que o usuário verá após selecionar uma determinada opção:

1. No formulário de criação ou edição da opção, selecione a **Próxima Pergunta** no campo correspondente.
2. Se nenhuma próxima pergunta for definida, o sistema seguirá a ordem padrão.

## API Endpoints

### Enviar Resposta do Usuário

**URL:** `/api/onboarding/responses`

**Método:** `POST`

**Parâmetros:**

- `question_id` (integer, obrigatório): ID da pergunta respondida.
- `response_id` (integer, opcional): ID da opção selecionada (para perguntas de escolha).
- `response` (string, opcional): Resposta do usuário (para perguntas de texto).

**Exemplo de Requisição:**

```json
POST /api/onboarding/responses
Content-Type: application/json

{
  "question_id": 1,
  "response_id": 5,
  "user_id": 123
}
```

**Exemplo de Resposta:**

```json
{
  "next_question": {
    "id": 2,
    "text": "Qual é a sua idade?",
    "type": "text",
    "options": []
  },
  "conditional_message": {
    "message": "Obrigado por escolher esta opção. Aqui está uma mensagem personalizada."
  }
}
```

### Obter Respostas do Usuário

**URL:** `/api/onboarding/user-responses`

**Método:** `GET`

**Parâmetros:**

- `user_id` (integer, obrigatório): ID do usuário.

**Exemplo de Requisição:**

```
GET /api/onboarding/user-responses?user_id=123
```

**Exemplo de Resposta:**

```json
{
  "responses": [
    {
      "question_id": 1,
      "question_text": "Qual é o seu nome?",
      "response": "João",
      "response_id": null,
      "option_text": null
    },
    {
      "question_id": 2,
      "question_text": "Qual é a sua cor favorita?",
      "response": null,
      "response_id": 5,
      "option_text": "Azul"
    }
    // Outras respostas...
  ]
}
```

## Exemplos de Uso

### Fluxo Básico de Onboarding

1. O usuário inicia o processo de onboarding.
2. A aplicação consome o endpoint para enviar as respostas do usuário.
3. O backend retorna a próxima pergunta e quaisquer mensagens condicionais.
4. O frontend exibe a pergunta e processa a resposta do usuário.
5. O fluxo continua até que não haja mais perguntas.

### Exibindo Mensagens Condicionais

- Quando o usuário seleciona uma opção com uma mensagem condicional, essa mensagem é retornada na resposta da API e pode ser exibida imediatamente.

### Controlando o Fluxo com Base nas Respostas

- Ao definir a **Próxima Pergunta** em uma opção, você pode direcionar o usuário para diferentes caminhos no fluxo de onboarding, criando experiências personalizadas.

## Licença

O OnboardingPackage é licenciado sob a [MIT license](LICENSE.md).