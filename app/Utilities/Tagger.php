<?php

namespace App\Utilities;

use App\Models\Tag;

class Tagger{

    /**
     *
     */
    public static function tagCafe($cafe, $tags)
    {
        foreach($tags as $tag){
            // Get the tag by name or create a new tag.
            $newCafeTag = \App\Models\Tag::firstOrNew(array('name' => $tag));
        }
    }


    /**
     *
     */
    private static function generateTagName($tagName)
    {

        /*
         * Trim whitespace from beginning and end of tag
         */
        $name = trim($tagName);

        /*
         * Convert tag name to lower.
         */
        $name = strtolower($name);

        /*
         * Convert anything not a letter or number to a dash.
         */
        $name = preg_replace('/[^a-zA-Z0-9]/', '-', $name);

        /*
         * Remove multiple instance of '-' and group to one.
         */
        $name = preg_replace('/-{2,}/', '-', $name);
        /*
         * Get rid of leading and trailing '-'
         */
        $name = trim($name, '-');

        /*
         * Returns the cleaned tag name
         */
        return $name;
    }

}
