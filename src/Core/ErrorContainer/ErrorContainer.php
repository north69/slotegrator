<?php

namespace Core\ErrorContainer;

class ErrorContainer
{
    public const FORMAT_RAW = 1;
    /** Вывод ошибок в формате ключ => значение */
    public const FORMAT_PLAIN = 2;
    /** Вывод ошибок в формате [[field => string, message => string]] */
    public const FORMAT_API = 3;
    /** Вывод ошибок в формате [[field => string, message => string, object_id => int]] */
    public const FORMAT_BUNCH_API = self::FORMAT_RAW;

    protected $errors = [];

    public function hasErrors(): bool
    {
        return (bool)$this->getErrors(self::FORMAT_RAW);
    }

    /**
     * @param int $format @see ErrorContainer::FORMAT_*
     * @return array
     * @throws \Exception
     */
    public function getErrors(int $format = self::FORMAT_PLAIN): array
    {
        switch ($format) {
            case self::FORMAT_RAW:
            case self::FORMAT_BUNCH_API:
                return $this->errors;
            case self::FORMAT_API:
                return $this->formatForApi();
            case self::FORMAT_PLAIN:
                return array_column($this->errors, 'message', 'field');
        }
        throw new \Exception("format of error display `{$format}` is unknown");
    }

    private function formatForApi(): array
    {
        $result = [];
        foreach ($this->errors as $error) {
            $result[] = [
                'field' => $error['field'],
                'message' => $error['message'],
            ];
        }
        return $result;
    }

    public function getError($attribute): ?string
    {
        $plain_errors = array_column($this->errors, 'message', 'field');
        return $plain_errors[$attribute] ?? null;
    }

    public function addError(string $field, string $message, $object_id = null): self
    {
        if ($object_id) {
            $field_by_object_id = array_column($this->errors, 'field', 'object_id');
            if (isset($field_by_object_id[$object_id]) && $field_by_object_id[$object_id] == $field) {
                return $this;
            }
        } elseif(in_array($field, array_column($this->errors, 'field'))) {
            return $this;
        }

        $this->errors[] = [
            'object_id' => $object_id,
            'field' => $field,
            'message' => $message
        ];
        return $this;
    }

    public function addErrors(array $errors): self
    {
        foreach ($errors as $error) {
            $this->addError($error['field'], $error['message'], $error['object_id'] ?? null);
        }
        return $this;
    }

    public function clearErrors(): void
    {
        $this->errors = [];
    }

    public function merge(ErrorContainer $error_container): void
    {
        $this->addErrors($error_container->getErrors(self::FORMAT_RAW));
    }
}