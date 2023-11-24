<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    protected array $messages = [
        500 => 'Something went wrong',
        503 => 'Service unavailable',
        404 => 'Not found',
        403 => 'Not authorized',
    ];

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $e
     *
     * @throws \Throwable
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function render(
        $request,
        \Throwable $e
    ) {
        $response = parent::render($request, $e);

        $status = $response->getStatusCode();

        // if (! array_key_exists($status, $this->messages)) {
        //     return $response;
        // }

        if (app()->environment(['local', 'testing'])) {
            // dd(
            //     $e->getMessage(),
            //     $e->getFile(),
            //     $e->getLine(),
            //     $e->getTraceAsString()
            // );
            // return $response;
            // throw $e;
            // dd(
            //     $e,
            //     $response,
            // );
            // return response()->json([
            //     'message' => $e->getMessage(),
            //     'errors' => $e->errors(),
            // ], $e->getCode() ?: $response->getStatusCode());
            // return redirect($response->getTargetUrl())->with('error', $e->getMessage());
            return back()
                // ->setStatusCode(422)
                ->with('error', $e->getMessage());
        }

        if (! $request->isMethod('GET')) {
            return back()
                ->setStatusCode($status)
                ->with('error', $this->messages[$status]);
        }

        return inertia('error/page', [
            'status' => $status,
            'message' => $this->messages[$status],
        ])
            ->toResponse($request)
            ->setStatusCode($status);
        // return parent::render($request, $e);
    }

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
