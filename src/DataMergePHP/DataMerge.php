<?php

namespace RobinMglsk;

class DataMerge
{

    protected $vars = [];

    public function __construct($vars = [])
    {
        $this->setVars($vars);
    }

    public function mergeStr($string)
    {
        $string = $this->oldTags($string);
        $string = $this->newTag($string);
        $string = $this->ucFirst($string);
        $string = $this->ucWords($string);
        $string = $this->strToLower($string);
        $string = $this->strToUpper($string);
        $string = $this->date($string);
        return $string;
    }

    public function setVars($vars)
    {
        $this->vars = [];
        foreach ($vars as $tag => $value) {
            if (!is_array($value) && !is_object($value)) {
                $this->vars[$tag] = strval($value);
            }
        }
        $this->vars['dump_all'] = json_encode($this->vars);
    }

    public function getVars()
    {
        return $this->vars;
    }

    private function oldTags($string)
    {
        foreach ($this->vars as $tag => $value) {
            $string = preg_replace('/\[%%( *)' . $tag . '( *)%%\]/i', $value, $string);
        }

        return $string;
    }

    private function newTag($string)
    {
        foreach ($this->vars as $tag => $value) {
            $found = [];
            preg_match_all('/{{( *)' . $tag . '( *)}}|{{( *)' . $tag . '( *)\|\|( *)\w+( *)}}/i', $string, $found);
            foreach ($found[0] as $tagFound) {
                if (empty(trim($tagFound))) continue;
                if (!empty($value)) {
                    $string = str_replace($tagFound, $value, $string);
                } else {
                    $pieces = explode('||', $tagFound, 2);
                    if (isset($pieces[1])) {
                        $string = str_replace($tagFound, trim($pieces[1], ' }'), $string);
                    } else {
                        $string = str_replace($tagFound, '', $string);
                    }
                }
            }
        }

        return $string;
    }

    private function ucFirst($string)
    {
        foreach ($this->vars as $tag => $value) {
            $found = [];
            preg_match_all('/{{( *)ucfirst\(( *)' . $tag . '( *)\)( *)}}|{{( *)ucfirst\(( *)' . $tag . '( *)\)( *)\|\|( *)\w+( *)}}/i', $string, $found);
            foreach ($found[0] as $tagFound) {
                if (empty(trim($tagFound))) continue;
                if (!empty($value)) {
                    $string = str_replace($tagFound, ucfirst(strtolower($value)), $string);
                } else {
                    $pieces = explode('||', $tagFound, 2);
                    if (isset($pieces[1])) {
                        $string = str_replace($tagFound, trim($pieces[1], ' }'), $string);
                    } else {
                        $string = str_replace($tagFound, '', $string);
                    }
                }
            }
        }
        return $string;
    }

    private function ucWords($string)
    {
        foreach ($this->vars as $tag => $value) {
            $found = [];
            preg_match_all('/{{( *)ucwords\(( *)' . $tag . '( *)\)( *)}}|{{( *)ucwords\(( *)' . $tag . '( *)\)( *)\|\|( *)\w+( *)}}/i', $string, $found);
            foreach ($found[0] as $tagFound) {
                if (empty(trim($tagFound))) continue;
                if (!empty($value)) {
                    $string = str_replace($tagFound, ucwords(strtolower($value)), $string);
                } else {
                    $pieces = explode('||', $tagFound, 2);
                    if (isset($pieces[1])) {
                        $string = str_replace($tagFound, trim($pieces[1], ' }'), $string);
                    } else {
                        $string = str_replace($tagFound, '', $string);
                    }
                }
            }
        }
        return $string;
    }

    private function strToLower($string)
    {
        foreach ($this->vars as $tag => $value) {
            $found = [];
            preg_match_all('/{{( *)strtolower\(( *)' . $tag . '( *)\)( *)}}|{{( *)strtolower\(( *)' . $tag . '( *)\)( *)\|\|( *)\w+( *)}}/i', $string, $found);
            foreach ($found[0] as $tagFound) {
                if (empty(trim($tagFound))) continue;
                if (!empty($value)) {
                    $string = str_replace($tagFound, strtolower($value), $string);
                } else {
                    $pieces = explode('||', $tagFound, 2);
                    if (isset($pieces[1])) {
                        $string = str_replace($tagFound, trim($pieces[1], ' }'), $string);
                    } else {
                        $string = str_replace($tagFound, '', $string);
                    }
                }
            }
        }

        return $string;
    }

    private function strToUpper($string)
    {
        foreach ($this->vars as $tag => $value) {
            $found = [];
            preg_match_all('/{{( *)strtoupper\(( *)' . $tag . '( *)\)( *)}}|{{( *)strtoupper\(( *)' . $tag . '( *)\)( *)\|\|( *)\w+( *)}}/i', $string, $found);
            foreach ($found[0] as $tagFound) {
                if (empty(trim($tagFound))) continue;
                if (!empty($value)) {
                    $string = str_replace($tagFound, strtoupper($value), $string);
                } else {
                    $pieces = explode('||', $tagFound, 2);
                    if (isset($pieces[1])) {
                        $string = str_replace($tagFound, trim($pieces[1], ' }'), $string);
                    } else {
                        $string = str_replace($tagFound, '', $string);
                    }
                }
            }
        }
        return $string;
    }

    private function date($string)
    {
        foreach ($this->vars as $tag => $value) {
            $found = [];
            preg_match_all('/{{( *)date\(( *)' . $tag . '( *)\)( *)}}|{{( *)date\(( *)' . $tag . '( *),( *)[a-zA-Z\\\:\/ \-]+( *)\)( *)}}|{{( *)date\(( *)' . $tag . '( *)\)( *)\|\|( *)\w+( *)}}|( *)date\(( *)' . $tag . '( *),( *)[a-zA-Z\\\:\/ \-]+( *)\)( *)\|\|( *)\w+( *)}}/i', $string, $found);
            foreach ($found[0] as $tagFound) {
                if (empty(trim($tagFound))) continue;
                if (!empty($value)) {
                    $start = strpos($tagFound, '(') + 1;
                    $end = strpos($tagFound, ')');
                    $vars = substr($tagFound, $start, ($end - $start));
                    $vars = explode(',', $vars);
                    if (isset($vars[1])) {
                        $string = str_replace($tagFound, date($vars[1], strtotime($value)), $string);
                    } else {
                        $string = str_replace($tagFound, date('d-m-Y H:i',  strtotime($value)), $string);
                    }
                } else {
                    $pieces = explode('||', $tagFound, 2);
                    if (isset($pieces[1])) {
                        $string = str_replace($tagFound, trim($pieces[1], ' }'), $string);
                    } else {
                        $string = str_replace($tagFound, '', $string);
                    }
                }
            }
        }
        return $string;
    }
}
