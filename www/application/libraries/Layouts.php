<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Layouts
{
    private $CI; // CodeIgniter instance 
    private $title_for_layout = NULL; // Title for the page
    private $title_separator = ' | '; // The title separator
    private $header_includes = []; // Stuff that will be included in the header
    private $footer_includes = []; // Stuff that will be included in the footer

    public function __construct()
    {
        $this->CI =& get_instance();
    }

    public function set_title($title) 
    { 
        $this->title_for_layout = $title;
    }

    public function view($view_name, $params = [], $layout = 'master')
    {
        // Handle the site's title. If NULL, don't add anything. If not, add a separator and append the title.
        if ($this->title_for_layout !== NULL) { 
            $this->title_for_layout = $this->title_for_layout . $this->title_separator; 
        }

        // Load the view's content, with the params passed 
        $view_content = $this->CI->load->view($view_name, $params, TRUE);

        // Load the layout, and pass the rendered view
        $this->CI->load->view('layouts/' . $layout, array(
            'content_for_layout' => $view_content,
            'title_for_layout' => $this->title_for_layout
        )); 
    }

    public function add_header_include($path, $prepend_base_url = FALSE) 
    { 
        if($prepend_base_url) { 
            $this->CI->load->helper('url'); // Load this just to be sure 
            $this->header_includes[] = base_url() . $path; 
        } 
        else { 
            $this->header_includes[] = $path;
        } 
            
        return $this; // This allows chain-methods 
    }

    public function add_footer_include($path, $prepend_base_url = FALSE) 
    { 
        if($prepend_base_url) { 
            $this->CI->load->helper('url'); // Load this just to be sure 
            $this->footer_includes[] = base_url() . $path; 
        } 
        else { 
            $this->footer_includes[] = $path;
        } 
            
        return $this; // This allows chain-methods 
    }

    public function print_header_includes()
    { 
        $final_includes = ''; // String that will hold all includes 
            
        foreach ($this->header_includes as $include) 
        { 
            // Check if it's a JS or a CSS file 
            if (preg_match('/js$/', $include)) 
            { 
            // It's a JS file 
            $final_includes .= '<script type="text/javascript" src="' . $include . '"></script>'; 
            } 
            elseif (preg_match('/css$/', $include)) 
            { 
            // It's a CSS file 
            $final_includes .= '<link rel="stylesheet" href="' . $include . '" type="text/css">'; 
            } 
        }

        return $final_includes;
    }

    public function print_footer_includes()
    { 
        $final_includes = ''; // String that will hold all includes 
            
        foreach ($this->footer_includes as $include) { 
            $final_includes .= '<script type="text/javascript" src="' . $include . '"></script>';
        }

        return $final_includes;
    }
}