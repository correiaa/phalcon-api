<?php

namespace App\Model;

trait ModelTrait
{
    public function beforeCreate()
    {
        $datetime = $this->getDateTime();
        $this->setCreatedAt($datetime);
        $this->setUpdatedAt($datetime);
    }

    public function beforeUpdate()
    {
        $this->setUpdatedAt($this->getDateTime());
    }

    /**
     * Get formatted datetime.
     *
     * @param string $format
     * @param int    $timestamp
     *
     * @return string
     */
    public function getDateTime(
        string $format = 'Y-m-d H:i:s',
        int $timestamp = 0
    ) : string {
        if ($timestamp > 0) {
            return date($format, $timestamp);
        }

        return date($format);
    }
}
