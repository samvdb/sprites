<?php

/*
 * This file is part of the Sprites package.
 *
 * (c) Pierre Minnieur <pm@pierre-minnieur.de>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Sprites\Tests\Processor;

use Sprites\Configuration;
use Sprites\Processor\DynamicProcessor;
use Sprites\Test\SpritesTestCase;

class DynamicProcessorTest extends SpritesTestCase
{
    public function testProcessing()
    {
        $config = new Configuration();
        $config->setImagine($this->getImagine());
        $config->setColor($this->getColor());
        $config->setImage(sprintf('%s/flags.png', $this->path));
        $config->setStylesheet(sprintf('%s/flags.css', $this->path));
        $config->setSelector(".flag.{{filename}}{background-position:{{pointer}}px 0px}\n");
        $config->getFinder()->name('*.png')->in(__DIR__.'/../Fixtures/flags')->sortByName();

        $processor = new DynamicProcessor();
        $processor->process($config);

        $sprite = $config->getImagine()->open($config->getImage());
        $result = $config->getImagine()->open(__DIR__.'/../Fixtures/results/flags.png');
        $this->assertImageEquals($sprite, $result);
        $this->assertFileEquals(__DIR__.'/../Fixtures/results/flags.css', $config->getStylesheet());
    }
}
