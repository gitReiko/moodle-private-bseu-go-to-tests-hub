<?php 

namespace Blocks\GoToTestsHub;

require_once 'data_getter.php';

class Main 
{
    const HUB_NOT_EXIST = 0;

    private $testHubId;

    function __construct()
    {
        $getter = new DataGetter;
        $this->$testHubId = $getter->get_tests_hub_id();
    }

    public function get_page() : string 
    {
        $page = '';

        if($this->$testHubId === self::HUB_NOT_EXIST)
        {
            $page.= $this->get_not_student_block();
        }
        else 
        {
            $page.= $this->get_link_block();
        }

        return $page;
    }

    private function get_not_student_block() : string 
    {
        $block = $this->get_owl_pic();

        $attr = array('style' => 'font-size: large;');
        $text = '<br>Блок предназначен только для студентов.';
        $block.= \html_writer::tag('p', $text, $attr);

        $attr = array('style' => 'font-size: large; color: red;');
        $text = 'Ссылка на тесты специализации не сформирована.';
        $block.= \html_writer::tag('p', $text, $attr);

        $attr = array('style' => 'font-size: large; color: red;');
        $text = 'Если Вы являетесь студентом, обратитесь в службу поддержки.';
        $block.= \html_writer::tag('p', $text, $attr); 

        $attr = array('style' => 'font-size: large;');
        $text = '<a href="tel:+375172097999">Городской телефон ☎ +375(17)-209-79-99</a>';
        $block.= \html_writer::tag('p', $text, $attr); 

        return $block;
    }

    private function get_link_block() : string 
    {
        $block = $this->get_owl_pic();
        $block.= $this->get_click_to_go_text();

        $block = \html_writer::tag('div', $block);

        $attr = array('href' => '/course/view.php?id='.$this->$testHubId);
        $block = \html_writer::tag('a', $block, $attr);

        return $block;
    }

    private function get_owl_pic() : string 
    {
        $attr = array(
            'style' => 'width: 100%; max-width: 640px;',
            'src' => '/blocks/gototestshub/pic/hat.jpg',
            'alt' => get_string('click_on_image', 'block_gototestshub')
        );

        return \html_writer::empty_tag('img', $attr);
    }

    private function get_click_to_go_text() : string 
    {
        $attr = array('style' => 'font-size: larger');
        $text = get_string('click_on_image', 'block_gototestshub');
        return \html_writer::tag('p', $text, $attr);
    }




}
