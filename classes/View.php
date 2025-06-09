<?php

class View {
    public static function render($viewName, $data = [], $layout = null) {
        // Extract data to variables
        extract($data);
        
        // Start output buffering
        ob_start();
        
        // Include the view file
        include __DIR__ . "/../views/{$viewName}.php";
        
        // Get the content
        $content = ob_get_clean();
        
        // If layout is specified, render with layout
        if ($layout) {
            // Set content for layout
            $data['content'] = $content;
            extract($data);
            include __DIR__ . "/../views/layouts/{$layout}.php";
        } else {
            // Just output the content
            echo $content;
        }
    }
    
    public static function renderWithLayout($viewName, $data = [], $layout = 'base') {
        self::render($viewName, $data, $layout);
    }
} 