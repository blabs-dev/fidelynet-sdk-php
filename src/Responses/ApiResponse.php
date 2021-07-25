<?php


namespace Blabs\FidelyNet\Responses;


use Spatie\DataTransferObject\DataTransferObject;

final class ApiResponse extends DataTransferObject
{
    /**
     * 
     *
     * @var int|string|null $returncode 
     */
    public $returncode;

    /**
     * 
     *
     * @var mixed $data 
     */
    public $data;

    /**
     * 
     *
     * @var mixed|null 
     */
    public $data2;

    /**
     * 
     *
     * @var mixed|null 
     */
    public $data3;

    /**
     * 
     *
     * @var mixed|null 
     */
    public $data4;

    /**
     * 
     *
     * @var mixed|null 
     */
    public $data5;

    /**
     * 
     *
     * @var string|null 
     */
    public $sessionid;

    /**
     * 
     *
     * @var string|null 
     */
    public $ambiente;
}
