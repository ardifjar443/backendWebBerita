<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;


class Handler extends ExceptionHandler
{
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
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        // Jika pengecualian adalah ModelNotFoundException
        if ($exception instanceof ModelNotFoundException) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        if ($exception instanceof QueryException && $exception->errorInfo[1] == 1062) {
            return response()->json(['error' => 'Judul sudah ada'], 422);
        }
        if (str_contains($exception->getMessage(), "Field 'title' doesn't have a default value")) {
            return response()->json(['error' => 'Judul tidak boleh kosong'], 422);
        }


        return parent::render($request, $exception);
    }
    protected function invalid($request, ValidationException $exception)
    {
        return response()->json([
            'message' => 'The given data was invalid.',
            'errors' => $exception->errors(),
        ], $exception->status);
    }

}