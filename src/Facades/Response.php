<?php
/**
 * author: draguo
 */

namespace Draguo\Http\Facades;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Facade as IlluminateFacade;

/**
 * @method static JsonResponse|JsonResource created($data = null, string $message = '')
 * @method static JsonResponse|JsonResource success($data = null, string $message = '', int $code = 200)
 * @method static void notFound(string $message = '')
 * @method static JsonResponse fail(string $message = '', int $code = 500)
 *
 * @see \Draguo\Http\Response
 */
class Response extends IlluminateFacade
{
    protected static function getFacadeAccessor()
    {
        return \Draguo\Http\Response::class;
    }
}
