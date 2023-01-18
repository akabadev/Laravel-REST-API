<?php

namespace App\Contracts\IO\Views;

use App\Http\Requests\Views\Beneficiary\CreateBeneficiaryViewRequest;
use App\Http\Requests\Views\Customer\CreateCustomerViewRequest;
use App\Http\Requests\Views\Service\CreateServiceViewRequest;
use App\Http\Requests\Views\User\CreateUserViewRequest;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\Validator;
use Throwable;

final class ViewsConfiguration
{
    private static ?self $instance = null;

    private function __construct()
    {
    }

    /**
     * @return ViewsConfiguration
     */
    public static function getInstance(): ViewsConfiguration
    {
        return self::$instance ?: self::$instance = new self();
    }

    protected array $validators = [
        "BENEFICIARIES" => CreateBeneficiaryViewRequest::class,
        "CUSTOMERS" => CreateCustomerViewRequest::class,
        "SERVICES" => CreateServiceViewRequest::class,
        "USERS" => CreateUserViewRequest::class,
    ];

    /**
     * @param array $baseForm
     * @param string|null $validatorCode
     * @return array
     * @throws Exception
     */
    protected function getViewForm(array $baseForm = [], ?string $validatorCode = null): array
    {
        $rules = $this->rulesAdapter($validatorCode);
        $data = [];

        collect($rules)->each(function ($rules, $key) use ($baseForm, &$data) {
            if ($children = data_get($baseForm, "$key.children", false)) {
                $childrenData = [];
                $parent = data_get($baseForm, $key);

                collect($children)->each(function ($child, $field) use ($key, $rules, &$childrenData, &$baseForm, &$parent) {
                    $validators = $this->parseRules(data_get($rules, $field));

                    return data_set(
                        $childrenData,
                        $field,
                        $this->tapFormField($validators, data_get($baseForm, "$key.children.$field"), $parent)
                    );
                });

                $data[$key] = array_merge(Arr::except($parent, 'children'), $childrenData);
            } elseif (data_get($baseForm, $key)) {
                data_set(
                    $data,
                    $key,
                    $this->tapFormField($this->parseRules($rules), data_get($baseForm, $key))
                );
            }
        });

        return $data;
    }

    /**
     * @param array $validators
     * @param array $oldValues
     * @param array $values
     * @return array
     */
    private function tapFormField(array $validators = [], array $oldValues = [], array $values = []): array
    {
        return [
            'label' => $oldValues['label'] ?? $values['label'],
            'type' => $oldValues['type'] ?? $values['type'],
            'canEdit' => $oldValues['canEdit'] ?? $values['canEdit'] ?? false,
            'validators' => $validators
        ];
    }

    /**
     * @param array $baseConfig
     * @param string|null $validatorCode
     * @return array
     * @throws Exception
     */
    public function getConfiguration(array $baseConfig = [], ?string $validatorCode = null): array
    {
        return [
            'ressourceLabel' => $this->getViewResourceLabel(data_get($baseConfig, 'ressourceLabel')),
            'baseURI' => $this->getViewRestUri(data_get($baseConfig, 'baseURI')),
            'columns' => $this->getViewColumns(data_get($baseConfig, 'columns', [])),
            'actions' => $this->getViewActions(data_get($baseConfig, 'actions', [])),
            'form' => $this->getViewForm(data_get($baseConfig, 'form', []), $validatorCode)
        ];
    }

    /**
     * @param array $baseColumns
     * @return array
     */
    protected function getViewColumns(array $baseColumns = []): array
    {
        return $baseColumns;
    }

    /**
     * @param array $baseActions
     * @return array
     */
    protected function getViewActions(array $baseActions = []): array
    {
        return $baseActions;
    }

    /**
     * @param string|null $baseResourceLabel
     * @return string|null
     */
    protected function getViewResourceLabel(?string $baseResourceLabel = null): ?string
    {
        return $baseResourceLabel;
    }

    /**
     * @param string|null $baseUri
     * @return string|null
     */
    protected function getViewRestUri(?string $baseUri = null): ?string
    {
        return $baseUri;
    }

    /**
     * @param FormRequest|Validator|string|null $formRequest
     * @return array
     * @throws Exception
     */
    protected function rulesAdapter(FormRequest|Validator|string|null $formRequest = null): array
    {
        if (null === $formRequest) {
            return [];
        }

        if ($formRequest instanceof Validator) {
            $base = $formRequest->getRules();
        } else {
            /** @var FormRequest $formRequest */
            $formRequest = is_string($formRequest) ? $this->validator($formRequest) : $formRequest;
            $base = $formRequest->rules();
        }

        $rules = [];

        foreach ($base as $key => $value) {
            data_fill($rules, $key, is_string($value) ? $value : implode('|', $value));
        }

        return $rules;
    }

    /**
     * @param string $rules
     * @return array
     */
    protected function parseRules(string $rules): array
    {
        return array_values(Arr::where(explode('|', $rules), function ($rule) {
            return !Str::contains($rule, ['exists', 'unique', 'in', 'with']);
        }));
    }

    /**
     * @param string $validatorCode
     * @return FormRequest
     * @throws Throwable
     */
    private function validator(string $validatorCode): FormRequest
    {
        /** @var FormRequest $request */
        $request = $this->validators[$validatorCode] ?? false;

        throw_if(!$request, new Exception("The code $validatorCode doesn't exist"));

        return new $request();
    }
}
