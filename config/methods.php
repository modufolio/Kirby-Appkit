<?php

return [

    'pageMethods' => [
        'linktag' => function () {
            return '<a href="' . $this->url() . '">' . $this->title()->html() . '</a>';
        },
        'hasParents' => function() {
            return $this->parents()->count();
        },

    ],
    'fieldMethods' => [

    ],

];