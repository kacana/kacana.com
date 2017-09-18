<?php namespace App\services;

use App\models\baseModel;
use UAParser\Parser;

/**
 * Class baseService
 * @package App\services
 */
class baseService
{

    /**
     * @var baseModel
     */
    public $_baseModel;

    /**
     * baseService constructor.
     */
    public function __construct()
    {

    }

    /**
     * @param $id
     * @param $status
     * @return mixed
     */
    public function changefieldDropdown($id, $status, $field, $table)
    {
        $baseModel = new baseModel();
        return $baseModel->changefieldDropdown($id, $status, $field, $table);
    }

    public function updateField($id, $content, $field, $table)
    {
        $baseModel = new baseModel();
        return $baseModel->updateField($id, $content, $field, $table);
    }

    public function getIpInformation($ip)
    {
        return json_decode(file_get_contents('http://freegeoip.net/json/' . $ip));;
    }

    public function parserUserAgent($userAgent)
    {
        $parser = Parser::create();
        $result = $parser->parse($userAgent);

        return $result;
    }

    public function fixStyleFormat($description)
    {
        $regEx = '/style=(.*?)>/';
        preg_match_all($regEx, $description, $data);

        $dataElements = $data[0];
        $dataStrings = $data[1];

        for ($i = 0; $i < count($dataElements); $i++) {
            $newStyle = 'style="' . str_replace(['"', '='], '', $dataStrings[$i]) . '">';
            $description = str_replace(($dataElements[$i]), $newStyle, $description);
        }

        return str_replace('text-align:justify;background:white"=""', '', $description);
    }

    public function trimElementDesc($description)
    {
        if (!trim($description))
            return '';

        $description = $this->fixStyleFormat($description);

        $dom = new \DOMDocument('1.0', 'UTF-8');
        libxml_use_internal_errors(true);
        $dom->loadHTML(mb_convert_encoding(trim($description), 'HTML-ENTITIES', "UTF-8"));

        $xpath = new \DOMXPath($dom);
        $nodeList = $xpath->evaluate('//p');

        for ($i = 0; $i < $nodeList->length; $i++) {

            $node = $nodeList->item($i);
            $childNode = $node->childNodes;
            $firstChildNode = $childNode->item(0);
            $parentNode = $node->parentNode;
            if (!(trim($node->textContent) || $node->getElementsByTagName('img')->length))
                $parentNode->removeChild($node);
            else if(isset($firstChildNode->tagName) && ($firstChildNode->tagName == 'figure')) {
                $node->parentNode->replaceChild($firstChildNode, $node);
            }
        }

        $nodeFigureList = $xpath->evaluate('//figure');

        for ($i = 0; $i < $nodeFigureList->length; $i++) {

            $node = $nodeFigureList->item($i);
            $childNode = $node->childNodes;
            $firstChildNode = $childNode->item(0);

            if (isset($firstChildNode) && $firstChildNode->tagName != 'img') {
                $node->parentNode->replaceChild($firstChildNode, $node);
            }

        }

        $nodeFigcaptionList = $xpath->evaluate('//figcaption');

        for ($i = 0; $i < $nodeFigcaptionList->length; $i++) {

            $node = $nodeFigcaptionList->item($i);
            $childNode = $node->childNodes;
            $firstChildNode = $childNode->item(0);

            if(isset($firstChildNode) && !trim($firstChildNode->textContent))
                $node->parentNode->removeChild($node);
            else if(isset($firstChildNode->tagName) && ($firstChildNode->tagName == 'figure' || $firstChildNode->tagName == 'figcaption')) {
                $node->parentNode->replaceChild($firstChildNode, $node);
            }

        }

        $description = $this->parseToCurrentString($dom);

        $description = str_replace('<b>', '<strong>', $description);
        $description = str_replace('</b>', '</strong>', $description);

        return trim($description);
    }

    public function parseToCurrentString($doc)
    {
        $xpath = new \DOMXPath($doc);
        $nodeList = $xpath->evaluate('//body');
        $body = $doc->saveHTML($nodeList->item(0));

        $body = str_replace('<body>', '', $body);
        $body = str_replace('</body>', '', $body);

        return $body;
    }


}


?>