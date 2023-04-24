<?php
get_header();

?>

<div id="primary" class="content-area">
    <main id="main" class="content site-main" role="main">
        <?php
            while(have_posts()):the_post();
                $fieldPrefix = FilmesReviews::FIELD_PREFIX;
                $imagem = get_the_post_thumbnail(get_the_ID(), 'medium');
                $imagemUrl = wp_get_attachment_image_src(get_the_post_thumbnail(get_the_ID(), 'medium'));

                $rating = (int)post_custom($fieldPrefix . 'filme_nota');
                $exibirRating = exibirRating($rating);

                $diretor = wp_strip_all_tags(post_custom($fieldPrefix . 'filme_diretor'));
                $site = esc_url(post_custom($fieldPrefix . 'filme_site'));
                $ano = (int)post_custom($fieldPrefix . 'filme_ano');
                $genero = get_the_terms(get_the_ID(), 'generos_filme');
                $filmeTipo = '';

                if ($genero && !is_wp_error($genero)):
                    $filmeTipo = array();
                    foreach ($genero as $gen):
                        $filmeTipo[] = $gen->name;
                    endforeach;
                endif;

                ?>
                    <article id="post-<?php the_ID();?>" <?php post_class('entry') ?>>
                        <header class="entry-header">
                            <?php the_title('<h1 class="entry-title">', '</h1>') ?>
                        </header>
                        <div class="entry-content">
                            <div class="left">
                            <?php
                                if (isset($imagem)):
                                    if (isset($site)):
                                        echo '<a href="' . $site . '" target="__blank">' . $imagem . '</a>';
                                    else:
                                        echo $imagem;
                                    endif;
                                endif;

                                if (!empty($exibirRating)):
                                    ?>
                                    <div class="rating rating-<?php echo $rating;?>">
                                        <?php echo $exibirRating ?>
                                    </div>
                                    <?php
                                endif;
                                ?>
                            <div class="filme-meta">
                                <?php if (!empty($diretor)): ?>
                                    <label>Dirigido por: </label><?php echo $diretor; ?>
                                <?php endif; ?>

                                <?php if (!empty($genero)): ?>
                                    <div class="genero">
                                        <label>Gênero: </label>
                                        <?php
                                            foreach ($filmeTipo as $t):
                                                echo $t . '';
                                            endforeach;
                                            ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if (!empty($ano)): ?>
                                    <div class="ano">
                                        <label>Lançamento: </label>
                                        <?php
                                            echo $ano;
                                            ?>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($site)): ?>
                                    <div class="site">
                                        <label>Site: </label>
                                        <?php echo '<a href="' . $site . '" target="__blank"> site do filme </a>'?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="right">
                                <div class="review-body">
                                    <?php the_content() ?>
                                </div>
                            </div>
                        </div>
                        <?php
                            edit_post_link(
                                __('Editar'),
                                '<footer class="entry-footer"> <span class="edit-link">',
                                '</span> </footer>'
                            );
                        ?>
                    </article>
                    <?php
                        /* comentários */
                        if (comments_open() || get_comments_number()):
                            comments_template();
                        endif;

                        /* navegação */
                        the_post_navigation(
                            array(
                                'next_text' =>  '<span class="meta-nav" aria-hidden="true">' .__('Próximo').'</span>'.
                                                '<span class="screen-reader-text">' .__('Próximo Review').'</span>'.
                                                '<span class="post-title"> %title </span>',

                                'prev-text' =>  '<span class="meta-nav" aria-hidden="true">' .__('Anterior').'</span>'.
                                                '<span class="screen-reader-text">' .__('Review Anterior').'</span>'.
                                                '<span class="post-title"> %title </span>'
                            )
                        )
                    ?>
                <?php
            endwhile;
        ?>
    </main>
</div>

<?php
get_footer();

function exibirRating($rating = null)
{
    $rating = (int) $rating;
    if ($rating > 0){
        $estrelasRating = array();

        for ($i=0; $i < floor($rating/2); $i++) {
            $estrelasRating[] = '<span class="dashicons dashicons-star-filled"></span>';
        }

        if ($rating % 2 === 1) {
            $estrelasRating[] = '<span class="dashicons dashicons-star-half"></span>';

        }

        $estrelasRating = array_pad($estrelasRating, 5, '<span class="dashicons dashicons-star-empty"></span>');
        return implode("\n", $estrelasRating);
    }
    return false;
}