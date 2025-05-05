# 🚀 Chat Furioso [Processo Seletivo Assistente de Engenharia de Software FURIA]

Este é um projeto Laravel moderno de acompanhamento para acompanhamento de partidas de CS criado para atender ao Challenge #1: Experiência Conversacional do Processo Seletivo Assistente de Engenharia de Software da FURIA.

---

## 📚 Índice

- [Tecnologias Utilizadas](#tecnologias-utilizadas)
- [Requisitos](#requisitos)
- [Instalação](#instalação)
- [Configuração](#configuração)
- [Execução](#execução)
- [Funcionalidades](#funcionalidades)
- [API REST](#api-rest)
- [Interacao com LLMs utilizando Prism](#llm-com-prism)
- [Broadcasting](#broadcasting)

---

## 🧰 Tecnologias Utilizadas

- Laravel Starter Kit
- Inertia.js (Vue.js)
- Laravel Reverb
- Laravel Echo
- Prism PHP
- API RESTful
- MySQL/PostgreSQL

---

## ✅ Requisitos

- PHP ^8.1
- Node.js >= 18
- Npm >= 9
- Composer
- MySQL

---

## ⚙️ Instalação

```bash
git clone https://github.com/IllgnerJose/chat-furioso.git
cd chat-furioso
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan storage:link
```

---

## 🔧 Configuração

### `.env`

Ajuste as variáveis de ambiente conforme necessário para o funcionamento correto da aplicação.

#### 🗄️ Banco de Dados

```env
DB_DATABASE=seu_banco
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

#### 🤖 Integração com API de Inteligência Artificial
> Este sistema utiliza o modelo [DeepSeek Prover v2 (Free)](https://openrouter.ai/deepseek/deepseek-prover-v2:free).

```env
DEEPSEEK_API_KEY=sua_chave
DEEPSEEK_URL=sua_url
```

---

## 🚀 Execução

```bash
php artisan migrate --seed
npm run dev
php artisan serve
php artisan reverb:start
```

---

## 💡 Funcionalidades

- SPA com Inertia.js
- WebSockets com Laravel Reverb + Echo
- API RESTful de partidas
- API de LLMs com [Laravel Prism](https://prismphp.com/)
- Estrutura moderna e escalável

---

## 📡 API REST

O sistema utiliza as seguintes rotas para gerenciar os jogos. Essas rotas estão relacionadas ao controle de jogos, incluindo suas ações de início, término e vitória.

### 1. `GET /games`

- **Método**: `GET`
- **Ação**: Exibe todos os jogos disponíveis.
- **Controlador**: `GameController@index`
- **Descrição**: Retorna uma lista de todos os jogos.

### 2. `POST /games`

- **Método**: `POST`
- **Ação**: Cria um novo jogo.
- **Controlador**: `GameController@store`
- **Descrição**: Recebe os dados do novo jogo e cria uma entrada no banco de dados.

### 3. `GET /games/start/{game}`

- **Método**: `GET`
- **Ação**: Inicia um jogo específico.
- **Controlador**: `GameController@start`
- **Nome da Rota**: `games.start`
- **Descrição**: Inicia o jogo especificado pelo id do model `{game}`.

### 4. `GET /games/end/{game}`

- **Método**: `GET`
- **Ação**: Finaliza um jogo específico.
- **Controlador**: `GameController@end`
- **Nome da Rota**: `games.end`
- **Descrição**: Finaliza o jogo especificado pelo id do model `{game}`.

### 5. `GET /games/team/{team}/win/{game}`

- **Método**: `GET`
- **Ação**: Declara o time como vencedor de uma rodade específica. Um ponto é marcado para o time e uma mensagem de comentário é salva pelo LLM.
- **Controlador**: `GameController@win`
- **Nome da Rota**: `games.win`
- **Descrição**: Declara o time `{team}` como vencedor do round atual no jogo `{game}`.

---

## 📈 Interacao com LLMs utilizando Prism

O serviço `CommentService` utiliza uma API de inteligência artificial para gerar comentários automáticos sobre os resultados das rodadas de um jogo. O processo envolve enviar o placar da rodada para a API, que retorna um comentário breve com base no resultado.

### **Fluxo de Geração de Comentários**

1. **Coleta de Dados da Rodada**:
    - A primeira etapa é coletar informações sobre a rodada do jogo, como os nomes dos times e o placar atual.
    - Essas informações são extraídas a partir do objeto `Round` (rodada), incluindo os nomes das equipes e suas pontuações.

2. **Criação do Prompt**:
    - Com base no placar, é criado um *prompt* com o formato:  
      `Gere um comentário breve para um round de Counter-Strike. Placar: Team1Score X Team2Score Team2. Use no máximo duas frases. Sempre em Português do Brasil`.

3. **Interação com a API de Inteligência Artificial**:
    - O *prompt* gerado é enviado para a API de IA do serviço Prism, especificamente utilizando o provedor **DeepSeek** (modelo `deepseek-prover-v2:free`).
    - A API processa o *prompt* e retorna um comentário com base no placar fornecido.

4. **Armazenamento do Comentário**:
    - O comentário gerado pela IA é armazenado no banco de dados, associado à rodada correspondente.

5. **Exemplo de Comentário Gerado**:
    - Um possível resultado poderia ser:  
      `Placar: 16-10. Team1 venceu a partida após uma excelente defesa na última rodada!`

### **Benefícios**:
- **Automação**: A geração automática de comentários elimina a necessidade de intervenção manual, tornando o processo mais rápido e eficiente.
- **Integração com IA**: O uso de uma API de IA permite a criação de comentários mais dinâmicos e interessantes, sem a necessidade de programação explícita de texto.
- **Escalabilidade**: A IA pode gerar comentários de forma consistente, mesmo para grandes quantidades de rodadas e jogos.

Essa funcionalidade melhora a experiência do usuário ao fornecer atualizações automáticas e envolventes sobre os jogos em tempo real, diretamente após a conclusão de cada rodada.

---

## 🔊 Broadcasting

Este sistema utiliza eventos para enviar notificações em tempo real para os clientes. Abaixo estão os detalhes dos eventos implementados:

### 1. **Evento: `CommentReceived`**

#### **Descrição**
Dispara quando um comentário é recebido em um jogo. Ele envia os dados do comentário para o canal privado correspondente ao jogo.

#### **Propriedades**
- **`$id`**: Identificador do comentário.
- **`$comment`**: O texto do comentário.
- **`$commentRoundTime`**: Hora em que o comentário foi feito, formatada como `d.m.Y H:i:s`.
- **`$gameId`**: Identificador do jogo.

#### **Canal de Transmissão**
- **Canal**: `PrivateChannel("comments.game.{$this->gameId}")`

#### **Método**
- **`broadcastOn()`**: Define o canal privado onde o evento será transmitido.

### 2. **Evento: `GameStarted`**

#### **Descrição**
Dispara quando um jogo é iniciado. Ele transmite as informações sobre o início do jogo, incluindo a rodada de início e o status do jogo.

#### **Propriedades**
- **`$roundStart`**: Hora de início da rodada.
- **`$gameRounds`**: Total de rodadas do jogo.
- **`$gameId`**: Identificador do jogo.
- **`$gameStatus`**: Status atual do jogo.

#### **Canal de Transmissão**
- **Canal**: `PrivateChannel("game.start.{$this->gameId}")`

#### **Método**
- **`broadcastOn()`**: Define o canal privado onde o evento será transmitido.

### 3. **Evento: `GameWon`**

#### **Descrição**
Dispara quando um jogo é concluído e um time é declarado vencedor. Ele envia informações sobre o status final do jogo, incluindo a pontuação dos times e o número de rodadas.

#### **Propriedades**
- **`$roundStart`**: Hora de início da última rodada.
- **`$team1Score`**: Pontuação do time 1.
- **`$team2Score`**: Pontuação do time 2.
- **`$gameRounds`**: Total de rodadas do jogo.
- **`$gameId`**: Identificador do jogo.

#### **Canal de Transmissão**
- **Canal**: `PrivateChannel("game.win.{$this->gameId}")`

#### **Método**
- **`broadcastOn()`**: Define o canal privado onde o evento será transmitido.

### 4. **Evento: `MessageReceived`**

#### **Descrição**
Dispara quando uma mensagem é recebida em um jogo. Ele transmite a mensagem e o nome do usuário que enviou a mensagem.

#### **Propriedades**
- **`$id`**: Identificador da mensagem.
- **`$message`**: Texto da mensagem.
- **`$who`**: Nome do usuário que enviou a mensagem.
- **`$game_id`**: Identificador do jogo.

#### **Canal de Transmissão**
- **Canal**: `PrivateChannel("messages.game.{$this->game_id}")`

#### **Método**
- **`broadcastOn()`**: Define o canal privado onde o evento será transmitido.
---


