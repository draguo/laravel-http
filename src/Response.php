<?php
/**
 * author: draguo
 */

namespace Draguo\Http;


use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\AbstractPaginator;

class Response
{

    /**
     * @param array|object|string $data
     * @param string $message
     * @return JsonResponse
     */
    public function created($data = [], string $message = '')
    {
        return $this->success($data, $message, 201);
    }

    /**
     *
     * @param JsonResource|array|mixed|string $data
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    public function success($data = [], string $message = '', int $code = 200)
    {
        if ($data instanceof ResourceCollection) {
            $data = $data->response()->getData(true);
        }

        if ($data instanceof JsonResource) {
            $data = $data->response()->getData(true);
        }

        if ($data instanceof Arrayable) {
            $data = $data->toArray();
        }

        if (func_num_args() == 1 && is_string($data)) {
            $message = $data;
            $data = [];
        }

        return $this->response($this->formatData($data, $message, 200), $code);
    }

    /**
     * Return an fail response.
     *
     * @param string $message
     * @param int $code
     * @return JsonResponse
     *
     * @throws HttpResponseException
     */
    public function fail(string $message = '', int $code = 500)
    {
        if (false !== strpos($message, '|')) {
            list ($code, $message) = explode('|', $message, 2);
        }

        return $this->response($this->formatData(null, $message, $code));
    }

    public function notFound($message = 'not found')
    {
        return $this->response($this->formatData(null, $message, 404), 404);
    }

    /**
     * Format normal array data.
     *
     * @param array|null $data
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    protected function formatArrayResponse(array $data, string $message = '', int $code = 200): JsonResponse
    {
        return $this->response($this->formatData($data, $message, $code), $code);
    }

    /**
     * Format return data structure.
     *
     * @param JsonResource|array|null $data
     * @param $message
     * @param $code
     * @return array
     */
    protected function formatData($data, $message, $code): array
    {
        $result = [
            'code' => (int)$code,
            'message' => $message,
        ];
        if (isset($data['data'])) {
            $result = array_merge($result, $data);
            return array_filter($result);
        }
        $result['data'] = $data;

        return array_filter($result);
    }

    /**
     * Return a new JSON response from the application.
     *
     * @param mixed $data
     * @param int $status
     * @return JsonResponse
     */
    protected function response($data = [], int $status = 200): JsonResponse
    {
        return new JsonResponse($data, $status);
    }
}
