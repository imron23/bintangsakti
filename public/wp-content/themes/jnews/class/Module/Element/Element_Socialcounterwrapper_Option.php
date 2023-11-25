<?php
/**
 * @author : Jegtheme
 */
namespace JNews\Module\Element;

use JNews\Module\ModuleOptionAbstract;

Class Element_Socialcounterwrapper_Option extends ModuleOptionAbstract
{
	public function get_category()
	{
		return esc_html__('JNews - Element', 'jnews');
	}

    public function compatible_column()
    {
        return array( 1,2,3,4,5,6,7,8,9,10,11,12 );
    }

    public function get_module_name()
    {
        return esc_html__('JNews - Social Counter Wrapper', 'jnews');
    }

	public function get_module_parent()
	{
		return array( 'only' => 'jnews_element_socialcounteritem' );
	}

    public function set_options()
    {
        $this->get_option();
        $this->set_style_option();
    }

    public function get_option()
    {
        $this->options[] = array(
            'type'          => 'dropdown',
            'param_name'    => 'column',
            'heading'       => esc_html__('Number of Column', 'jnews'),
            'description'   => esc_html__('Set the number of social counter column.', 'jnews'),
            'std'           => 'col1',
            'value'         => array(
                esc_html__('1 Column', 'jnews')     => 'col1',
                esc_html__('2 Columns', 'jnews')    => 'col2',
                esc_html__('3 Columns', 'jnews')    => 'col3',
                esc_html__('4 Columns', 'jnews')    => 'col4',
            ),
        );

	    $this->options[] = array(
		    'type'          => 'dropdown',
		    'param_name'    => 'style',
		    'heading'       => esc_html__('Social Style', 'jnews'),
		    'description'   => esc_html__('Choose your social counter style.', 'jnews'),
		    'std'           => 'light',
		    'value'         => array(
			    esc_html__('Light', 'jnews')    => 'light',
			    esc_html__('Colored', 'jnews')  => 'colored',
		    ),
	    );

	    $this->options[] = array(
		    'type'          => 'checkbox',
		    'param_name'    => 'newtab',
		    'heading'       => esc_html__('Open New Tab', 'jnews'),
		    'description'   => esc_html__('Open social account page on new tab.', 'jnews')
	    );

	    $this->options[] = array(
		    'type'          => 'textfield',
		    'param_name'    => 'tw_consumer_key',
		    'heading'       => esc_html__('Twitter Consumer Key','jnews'),
		    'description'   => sprintf(__('You can create an application and get Twitter Consumer Key <a href="%s" target="_blank">here</a>.', 'jnews'), 'https://apps.twitter.com/')
	    );

	    $this->options[] = array(
		    'type'          => 'textfield',
		    'param_name'    => 'tw_consumer_secret',
		    'heading'       => esc_html__('Twitter Consumer Secret','jnews'),
		    'description'   => sprintf(__('You can create an application and get Twitter Consumer Secret <a href="%s" target="_blank">here</a>.', 'jnews'), 'https://apps.twitter.com/')
	    );

	    $this->options[] = array(
		    'type'          => 'textfield',
		    'param_name'    => 'tw_access_token',
		    'heading'       => esc_html__('Twitter Access Token','jnews'),
		    'description'   => sprintf(__('You can create an application and get Twitter Access Token <a href="%s" target="_blank">here</a>.', 'jnews'), 'https://apps.twitter.com/')
	    );

	    $this->options[] = array(
		    'type'          => 'textfield',
		    'param_name'    => 'tw_access_token_secret',
		    'heading'       => esc_html__('Twitter Access Token Secret','jnews'),
		    'description'   => sprintf(__('You can create an application and get Twitter Access Token Secret <a href="%s" target="_blank">here</a>.', 'jnews'), 'https://apps.twitter.com/')
	    );

	    $this->options[] = array(
		    'type'          => 'textfield',
		    'param_name'    => 'bh_key',
		    'heading'       => esc_html__('Behance API Key','jnews'),
		    'description'   => sprintf(__('You can register Behance API Key <a href="%s" target="_blank">here</a>.', 'jnews'), 'https://www.behance.net/dev/register')
	    );

	    $this->options[] = array(
		    'type'          => 'textfield',
		    'param_name'    => 'vk_id',
		    'heading'       => esc_html__('VK User ID','jnews'),
		    'description'   => esc_html__('Insert your VK user id.', 'jnews'),
		);
		
		$this->options[] = array(
		    'type'          => 'textfield',
		    'param_name'    => 'vk_token',
		    'heading'       => esc_html__('VK Service Token','jnews'),
		    'description'   => esc_html__('Insert your VK service token.', 'jnews'),
		);

	    $this->options[] = array(
		    'type'          => 'textfield',
		    'param_name'    => 'rss_count',
		    'heading'       => esc_html__('RSS Subscriber','jnews'),
		    'description'   => esc_html__('Insert the number of RSS subscriber.', 'jnews'),
	    );
    }
}