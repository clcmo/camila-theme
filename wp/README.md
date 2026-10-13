# Tema Camila L. Oliveira (WordPress, MVC)

## Instalação

1. Aparência → Temas → Adicionar novo → Enviar tema → escolha `camila-oliveira.zip` → Ativar.
2. Crie as páginas **Sobre**, **Livros** (slug `livros`), **Contato** (slug `contato`), **Vídeos** (`videos`) e **Sons** (`sons`); o tema usa o template de cada slug automaticamente.
3. Em Configurações → Leitura, defina a página inicial estática e a página de posts como **Blog**.
4. Aparência → Personalizar → "Camila L. Oliveira": foto da capa, chamada da newsletter, canal do YouTube.

## Conteúdo próprio (menu lateral do painel)

- **Livros**: capa = imagem destacada; campos Ano, Editora e **Onde comprar** (`Loja | https://…`, uma por linha); organize em Coleções (Ficção, Não ficção…).
- **Vídeos**: cole o link do YouTube. **Sons**: escolha o áudio na biblioteca.

## WooCommerce

- Com o WooCommerce ativo, salvar um livro cria ou atualiza um produto simples como rascunho, sincronizando título, descrição, resumo e capa.
- Preço, estoque e publicação são gerenciados no produto WooCommerce. No editor do livro, use o painel **Produto WooCommerce** para abrir o produto vinculado.
- No produto, preencha **Link da edição física** em Dados do produto → Geral para mostrar o botão **Ver edição física** na página pública. A data de publicação não é exibida nas páginas de produto.
- Livros cadastrados antes da integração serão sincronizados ao serem salvos novamente.

## Arquitetura

- `app/Models` dados e regras: Book, Video, Sound, Article, Menu.
- `app/Controllers` recebem a requisição, pedem dados aos Models e escolhem a View.
- `app/Views` apenas HTML (layouts, partials, pages, admin).
- `app/Core` Autoloader, Router, View e Controller base. Os arquivos da raiz (`front-page.php`, `page-livros.php`…) só chamam `Router::dispatch()`.

## Marca

SVG em `assets/img/` (vetorizado de uma imagem; para fidelidade total substitua pelos SVGs exportados do Pages). Efeitos em `theme.css` (seção "Efeitos da marca"). Para usar a fonte Centers George, veja `assets/fonts/LEIA-ME.txt`.

## Observações

- Fontes Outfit e Literata são carregadas do Google Fonts.
- Newsletter nativa guarda os e-mails na opção `clo_newsletter_list`; para Jetpack/Mailchimp, cole o shortcode em Personalizar.
- Revisado com `php -l` (sem erros de sintaxe); ainda não testado em uma instalação WordPress real.
