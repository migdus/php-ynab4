<?php

namespace MTools\Ynab\Parser;

use MTools\Ynab\Entity\YnabVersion;

/**
 * Class YnabVersionParser
 *
 * @package MTools\Ynab\Entity
 */
class YnabVersionParser extends YnabBaseVersionParser
    implements YnabParserInterface
{
    /**
     * @var string
     */
    protected $knowledge;

    /**
     * YnabVersionParser constructor.
     * @param $knowledge
     */
    public function __construct($knowledge)
    {
        $this->knowledge = $knowledge;
    }

    /**
     * Parse knowledge string to versions
     *
     * @return YnabVersion[]
     */
    public function parse()
    {
        $versions = null;
        if (null !== $this->knowledge) {
            $versions = $this->parseVersionList($this->knowledge);
        }

        return $versions;
    }


}