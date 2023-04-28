<?php
class NewsletterCursoWidget extends WP_Widget
{

/**
 * Sets up the widgets name etc
 */
public function __construct()
{
    parent::__construct(
        'newsletter_curso_widget', // Base ID
        esc_html__('Newsletter Curso', 'ns_domain'), // Name
        array('description' => esc_html__('Newsletter Curso', 'ns_domain'),) // Args
    );
}

/**
 * Outputs the content of the widget
 *
 * @param array $args
 * @param array $instance
 */
public function widget($args, $instance)
{
    // outputs the content of the widget
}

/**
 * Outputs the options form on admin
 *
 * @param array $instance The widget options
 */
public function form($instance)
{
    $title = empty($instance['title']) ? $instance['title'] : __('Newsletter Curso', 'ns_domain');
    $recipient = $instance['recipient'];
    $subject = empty($instance['subject']) ? $instance['subject'] : __('Você tem um novo inscrito!', 'ns_domain');
    ?>
    <p>
        <label for="<?= $this->get_field_id('title'); ?>">
            <?= __('Título');?>
        </label><br>
        <input
            type="text"
            id="<?=$this->get_field_id('title');?>"
            name="<?= $this->get_field_name('title');?>"
            value="<?= esc_attr($title)?>"
        >
        <label for="<?= $this->get_field_id('recipient'); ?>">
            <?= __('Destinatário');?>
        </label><br>
        <input
            type="text"
            id="<?=$this->get_field_id('recipient');?>"
            name="<?= $this->get_field_name('recipient');?>"
            value="<?= esc_attr($recipient)?>"
        >
        <label for="<?= $this->get_field_id('subject'); ?>">
            <?= __('Assunto');?>
        </label><br>
        <input
            type="text"
            id="<?=$this->get_field_id('subject');?>"
            name="<?= $this->get_field_name('subject');?>"
            value="<?= esc_attr($subject)?>"
        >
    </p>
    <?php
}

/**
 * Processing widget options on save
 *
 * @param array $new_instance The new options
 * @param array $old_instance The previous options
 *
 * @return array
 */
public function update($newInstance, $oldInstance)
{
    // processes widget options to be saved
    return array(
        'title' =>(!empty($newInstance['title'])) ? strip_tags($newInstance['title']) : '',
        'recipient' =>(!empty($newInstance['recipient'])) ? strip_tags($newInstance['recipient']) : '',
        'subject' =>(!empty($newInstance['subject'])) ? strip_tags($newInstance['subject']) : ''
    );
}
}