=== Recomendação de moda ===
Contributors: hookit, edpittol
Tags: recomendação, moda, afiliados, monetização, produtos relacionados, comissão de venda, tracking de venda, blog de moda, roupas, sapatos, vestuário, maquiagem, looks, varejo de moda.
Requires at least: 2.8
Tested up to: 4.3
Stable tag: trunk
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/old-licenses/gpl-2.0.txt

Este plugin de recomendação possibilita monetizar o conteúdo de seu blog através de comissão de venda dos produtos relacionados.

== Description ==

Exiba roupas, acessórios, sapatos, vestuário, maquiagens  e demais produtos relacionados com os seus posts. Este plugin de recomendação possibilita monetizar o conteúdo de seu blog através de comissão de venda dos produtos relacionados.  

Instale este plugin e faça seu cadastro na nossa base de produtos de moda pelo site www.hookit.cc para ativar a recomendação.

No Hookit.cc você encontra as principais marcas e varejistas de moda, e você pode ter os melhores produtos associados ao seu conteúdo. Veja um exemplo do plugin funcionando aqui: http://revistadonna.clicrbs.com.br/moda/

== Installation ==

Após a ativação do plugin. Todo post criado ou atualizado exibirá após o conteúdo os produtos relacionado com ele.

== Frequently Asked Questions ==

= Como mudar o título 'Produtos Recomendados' =

É necessário adicionar um filtro no arquivo `functions.php`.

`function mytheme_hookit_recommended_products_title( $title ) {
	return 'Confira produtos relacionados a esse post';
}
add_filter( 'hookit_recommended_products_title', 'mytheme_hookit_recommended_products_title' );`

== Changelog ==

= 0.6.2 =
* Fix: Matém todos produtos com a mesma altura

= 0.6.1 =
* Fix: Corrigida conexão com Web Service

= 0.6.0 =
* Seleção do gênero dos produtos recomendados
* Ferramenta para atualizar todos posts
* Assinatura "Recomendado por Hookit"

= 0.5.4 =
* Fix: Limitar a quantidade de produtos exibidos para 4 quando não configurado

= 0.5.3 =
* Fix: múltiplas chamadas ao filtro the_content
* Ativa os produtos recomendados para todas categorias se nenhuma categoria for selecionada

= 0.5.2 =
* Consertado retorno de erro do web service, quando existir
* Consertado estilo da metabox do post

= 0.5.1 =
* Alterado funcionamento da URL do produto

= 0.5 =
* Suporte para selecionar categorias que devem aparecer os produtos recomendados
* Fix: Classe do elemento no front-end

= 0.4 =
* Adicionado tags na avaliação dos produtos recomendados

= 0.3.1 =
* Adicionado token da Hookit na página de configuração
* Adicionado link de afiliado faltante nos produtos
* Exibe produtos relacionados apenas na página do post (singular page)
* Esconde o título quando do widget após o post quando não há produtos

= 0.3 =
* Alterado nome do plugin para Hookit Produtos Relacionados
* Página de configuração

= 0.2 =
* Adicionado filtro para personalizar título da lista de produtos relacionados
* Opção para desativar produtos relacionados em um post

= 0.1 =
* Initial Version.