<?php

namespace App\Services\Helpers\Alert;

/**
 * Class Alert
 */
class Alert
{
    /**
     * @param $message
     * @param AlertType $type
     * @return void
     */
    public function set($message, AlertType $type = AlertType::SUCCESS)
    {
        session()->flash(Alert::class . '_message', $message);
        session()->flash(Alert::class . '_type', $type);
    }

    /**
     * @return array
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function get()
    {
        return [
            'message' => session()->get(Alert::class . '_message'),
            'type' => session()->get(Alert::class . '_type'),
        ];
    }
}
