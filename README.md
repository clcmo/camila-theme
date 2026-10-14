# Tema Camila L. Oliveira (WordPress, MVC)

[![GitHub license](https://img.shields.io/github/license/clcmo/camila-theme?style=for-the-badge)](https://github.com/clcmo/camila-theme)
[![GitHub stars](https://img.shields.io/github/stars/clcmo/camila-theme?style=for-the-badge)](https://github.com/clcmo/camila-theme/stargazers)
[![GitHub forks](https://img.shields.io/github/forks/clcmo/camila-theme?style=for-the-badge)](https://github.com/clcmo/camila-theme/network)
[![GitHub issues](https://img.shields.io/github/issues/clcmo/camila-theme?style=for-the-badge)](https://github.com/clcmo/camila-theme/issues)
[![GitHub donate](https://img.shields.io/github/sponsors/clcmo?color=pink&style=for-the-badge)](https://github.com/sponsors/clcmo)



Tema profissional WordPress estruturado em padrão arquitetural MVC para gerenciamento de portfólio literário, produções multimídia (MediaCast) e integração automatizada de e-commerce.

## 🛠️ Requisitos do Ambiente
* **Servidor de Produção:** Apache HTTP Server com suporte a PHP 8.1+ e MySQL.
* **Ambiente de Homologação / Staging:** GitHub Pages configurado via GitHub Actions nativo.
* **Dependências Opcionais:** WooCommerce ativo para sincronização de catálogo de livros.

## 🚀 Instalação e Configuração

### 1. Instalação do Tema no WordPress
1. Acesse o painel administrativo: **Aparência** → **Temas** → **Adicionar novo** → **Enviar tema**.
2. Selecione o arquivo compilado `camila-oliveira.zip` (ou a pasta do tema via Git) e clique em **Ativar**.

### 2. Configuração das Páginas Obrigatórias
Crie as páginas listadas abaixo no painel do WordPress. O roteador interno do tema interceptará os *slugs* exatos para renderizar as Views correspondentes:
* **Sobre**
* **Livros** (slug: `livros`)
* **Contato** (slug: `contato`)
* **Vídeos** (slug: `videos`) — *MediaCast Video*
* **Sons** (slug: `sons`) — *MediaCast Audio*

### 3. Ajustes de Leitura e Personalização
1. Vá em **Configurações** → **Leitura**, defina uma página inicial estática de sua preferência e configure a página de posts como **Blog**.
2. Acesse **Aparência** → **Personalizar** → **"Camila L. Oliveira"** para configurar os campos globais: foto de capa, chamada da newsletter e o link do canal do YouTube.

## 📦 Gerenciamento de Conteúdo Customizado (CPT)

O tema cria menus laterais dedicados no painel para isolar as regras de negócio de mídia e literatura:

* **Livros:** 
  * A capa deve ser inserida no campo **Imagem Destacada**.
  * Preencha os metadados nos campos customizados: **Ano** e **Editora**.
  * **Onde comprar:** Insira no formato `Nome da Loja | https://link-da-loja.com` (uma loja por linha).
  * Classifique os títulos através da taxonomia de **Coleções** (ex: Ficção, Não ficção).
* **Vídeos (MediaCast):** Crie um post de vídeo e cole a URL direta do YouTube no campo correspondente para o player nativo interceptar.
* **Sons (MediaCast):** Crie um post de áudio e selecione ou envie o arquivo de som (MP3/M4A) diretamente através da biblioteca de mídia.

## 🛍️ Integração Nativa com WooCommerce

O tema possui um sincronizador inteligente em segundo plano para automatizar o catálogo comercial:
* **Sincronização de Cadastro:** Salvar ou atualizar um post de *Livro* criará ou atualizará automaticamente um produto simples no WooCommerce em modo **Rascunho**. O sistema sincroniza de forma transparente o título, descrição, resumo e imagem de capa.
* **Gestão Comercial:** Parâmetros de preço, controle de estoque e a publicação final na loja online devem ser gerenciados diretamente na interface do produto do WooCommerce. O editor do livro exibirá um painel lateral chamado **Produto WooCommerce** com o link direto para o item vinculado.
* **Edição Física:** No painel do produto do WooCommerce, preencha o campo customizado **Link da edição física** em *Dados do Produto → Geral* para habilitar o botão público **"Ver edição física"** na página do livro. A data de publicação do livro é ocultada na página do produto para priorizar o fluxo comercial.
* **Legado:** Livros cadastrados antes da ativação do WooCommerce serão integrados e sincronizados assim que forem salvos novamente pelo administrador.

## 📐 Arquitetura do Sistema (MVC Customizado)

O tema adota uma estrutura desacoplada para evitar arquivos PHP inflados e misturados com marcação visual, delegando o ciclo de vida da requisição para componentes especialistas:

```text
├── app/
│   ├── Core/         # Autoloader, Router, View base e Controller base
│   ├── Models/       # Processamento de dados e queries (Book, Video, Sound, Article, Menu)
│   ├── Controllers/  # Interceptam a requisição, consultam os Models e disparam a View
│   └── Views/        # Arquivos puros de marcação HTML (layouts, partials, pages, admin)
├── assets/           # Arquivos estáticos compilados (css, js, imagens, fontes)
└── *.php (Raiz)      # Arquivos obrigatórios do WP (front-page.php, page-livros.php, etc.) 
                      # que atuam apenas como gatilho disparando o 'Router::dispatch()'
```

## 🎨 Identidade Visual e Marca
* **Vetorização:** Os arquivos SVG da marca estão localizados em `assets/img/`. Para garantir fidelidade total de renderização e evitar distorções de renderização, utilize os SVGs exportados diretamente das ferramentas de design.
* **Estilização:** Os efeitos de transição contínua e animações visuais da marca estão isolados na seção `"Efeitos da marca"` dentro de `assets/css/theme.css`.
* **Tipografia:** Para aplicar a fonte tipográfica corporativa *Centers George*, consulte as instruções de licenciamento e carregamento local descritas em `assets/fonts/LEIA-ME.txt`. As fontes de apoio *Outfit* e *Literata* são carregadas externamente via CDN do Google Fonts.

## 📡 Integração Contínua e Prévia Estática (CI/CD)

O repositório possui uma esteira automatizada baseada em **GitHub Actions** (`.github/workflows/deploy.yml`):
1. **Deploy Dinâmico (Produção):** Sincroniza via FTP todos os arquivos PHP do tema e a estrutura MVC para a pasta de temas do WordPress hospedada no Apache externo.
2. **Deploy Estático (Homologação):** Isola, limpa as tags PHP e compila os arquivos `.html` de teste e prévias estáticas da pasta `wp`, publicando-os automaticamente via GitHub Pages nativo no subdomínio configurado (ex: `://camilaloliveira.com`).

## 📌 Notas de Desenvolvimento
* **Validação:** Todos os arquivos da estrutura passaram por análise estática via linter (`php -l`) e estão livres de erros de sintaxe.
* **Newsletter:** O sistema de captura nativo armazena a lista de e-mails de ouvintes/leitores de forma interna na tabela de opções do WordPress (`clo_newsletter_list`). Caso prefira utilizar ferramentas externas (como Jetpack ou Mailchimp), basta colar o shortcode gerado diretamente no menu *Aparência → Personalizar*.
* **Status de Teste:** Arquitetura homologada no ambiente estático do GitHub Pages; validações em ambiente de produção WordPress real estão em andamento.
