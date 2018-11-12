<?php
namespace App\Http\Middleware;

use App\Exceptions\RoomServiceValidation;
use Closure;
use Illuminate\Http\Request;
use JsonSchema\Validator as JsonValidator;

class RoomHooverRequestValidator
{

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param null $guard
     *
     * @return mixed
     * @throws \App\Exceptions\RoomServiceValidation
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        $validator = new JsonValidator();
        $json = (object) $request->json()->all();
        $validator->validate($json, (object)['$ref' => 'file://' . app()->resourcePath('jsonschema/room.hoover.request.json')]);

        if (!$validator->isValid()) {
            $messages = [];
            foreach ($validator->getErrors() as $error) {
                $messages[] = sprintf("[%s] %s", $error['property'], $error['message']);
            }
            throw new RoomServiceValidation(implode(". ", $messages));
        }

        return $next($request);
    }
}
