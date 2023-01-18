<?php

namespace App\Http\Requests\Process;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="CreateProcessRequest",
 *     description="CreateProcessRequest",
 *     required=true,
 *     @OA\JsonContent(
 *         @OA\Property(property="code", type="string", example="92879827-UII"),
 *         @OA\Property(property="description", type="string", example="Description..."),
 *         @OA\Property(property="invokable", type="string", example="MorphToClass")
 *     )
 * )
 *
 * Class CreateProcessRequest
 * @package App\Http\Requests\Process
 */
class CreateProcessRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            "invokable" => $this->resolveInvokable(null)
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "code" => "required|alpha_num",
            "description" => "required|string",
            "invokable" => "required|string"
        ];
    }

    private function resolveInvokable(?string $invokable): string
    {
        return "x";
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return ["invokable" => "Associated job (this->job) is not defined"];
    }
}
