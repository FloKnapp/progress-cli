<?php

namespace ProgressCli;

/**
 * Class Progress
 *
 * A simple cli progress bar
 *
 * @author Florian Knapp <florian.knapp@check24.de>
 */
class Progress
{
    /** @var integer */
    private $total = 0;

    /** @var integer */
    private $current = 0;

    /** @var integer */
    private $chars = 0;

    /** @var string */
    private $startLimiter = '[';

    /** @var string */
    private $endLimiter = ']';

    /** @var string */
    private $progressChar = '-';

    /** @var boolean */
    private $showSummary = false;

    /** @const integer */
    const DEFAULT_CHAR_LENGTH = 40;

    /** @const string */
    const CR = "\r";

    /**
     * Progress constructor.
     *
     * @param integer $total
     * @param integer $chars
     */
    public function __construct($total = 0, $chars = self::DEFAULT_CHAR_LENGTH, $showSummary = false)
    {
        $this->setTotal($total);
        $this->setChars($chars);
        $this->showSummary($showSummary);
    }

    /**
     * @return integer
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param array|integer $total
     */
    public function setTotal($total = self::DEFAULT_CHAR_LENGTH)
    {
        if (is_array($total)) {
            $total = count($total);
        }

        $this->total = $total;
    }

    /**
     * @return integer
     */
    public function getChars()
    {
        return $this->chars;
    }

    /**
     * @param integer $chars
     */
    public function setChars($chars = 40)
    {
        $this->chars = $chars;
    }

    /**
     * @param string $start
     * @param string $end
     */
    public function setProgressLimiter($start = '[', $end = ']')
    {
        $this->startLimiter = $start;
        $this->endLimiter   = $end;
    }

    /**
     * @param string $progressChar
     */
    public function setProgressChar($progressChar = '-')
    {
        $this->progressChar = $progressChar;
    }

    /**
     * @param boolean $value
     */
    public function showSummary($value = false)
    {
        $this->showSummary = $value;
    }

    /**
     * @param integer $current
     * @return boolean
     */
    public function update($current = 0)
    {
        if ($this->total === 0 || $this->chars === 0) {
            throw new \InvalidArgumentException('Process: No total amount given, abort...');
        }

        $this->current = $current;
        usleep(1); // Prevents cursor from jumping around
        return $this->display();
    }

    /**
     * @return boolean
     */
    private function display()
    {
        $this->begin();

        $percent = round($this->current / $this->total * 100, 0);

        $output = self::CR
            . $this->startLimiter
            . str_pad(str_pad('', $this->percentBar($percent), $this->progressChar), $this->chars)
            . $this->endLimiter
            . str_pad($percent, 4, ' ', STR_PAD_LEFT)
            . '%';

        if ($this->showSummary) {
            $summary = $this->formatSummary();
            $output .= str_pad($summary, strlen($summary) + 1, ' ', STR_PAD_LEFT);
        }

        print $output;

        $this->done();

        return true;
    }

    /**
     * @return boolean
     */
    private function begin()
    {
        if ($this->current === 0) {
            print PHP_EOL;
        }

        return true;
    }

    /**
     * @return boolean
     */
    private function done()
    {
        if ($this->current !== $this->total - 1) {
            return false;
        }

        $output = self::CR
            . $this->startLimiter
            . str_pad(str_pad('', $this->chars, $this->progressChar), $this->chars)
            . $this->endLimiter
            . ' 100%';

        if ($this->showSummary) {
            $summary = $this->formatSummary(true);
            $output .= str_pad($summary, strlen($summary) + 1, ' ', STR_PAD_LEFT);
        }

        print $output . PHP_EOL . PHP_EOL;

        return true;
    }

    /**
     * @param boolean $final
     * @return string
     */
    private function formatSummary($final = false)
    {
        if ($final) {
            return '(' . number_format($this->total) . '/' . number_format($this->total) . ')';
        }

        return '(' . number_format($this->current) . '/' . number_format($this->total) . ')';
    }

    /**
     * @param $percent
     * @return integer
     */
    private function percentBar($percent)
    {
        return (int)round($this->chars / 100 * $percent, 0);
    }

}
