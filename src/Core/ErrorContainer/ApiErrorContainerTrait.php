<?php

namespace Core\ErrorContainer;

trait ApiErrorContainerTrait
{
    protected $error_container = null;

    public function getErrorContainer(): ?ErrorContainer
    {
        if (is_null($this->error_container)) {
            $this->error_container = new ErrorContainer();
        }
        return $this->error_container;
    }

    public function hasErrors(): bool
    {
        return $this->getErrorContainer()->hasErrors();
    }

    public function getErrors(bool $bunch_api_format = false): array
    {
        $format = $bunch_api_format ? ErrorContainer::FORMAT_BUNCH_API : ErrorContainer::FORMAT_API;
        return $this->getErrorContainer()->getErrors($format);
    }

    public function getError($attribute): ?string
    {
        return $this->getErrorContainer()->getError($attribute);
    }

    public function addError(string $attribute, string $error, int $object_id = null): self
    {
        $this->getErrorContainer()->addError($attribute, $error, $object_id);
        return $this;
    }

    public function addErrors(array $errors): self
    {
        $this->getErrorContainer()->addErrors($errors);
        return $this;
    }

    public function mergeErrors(ErrorContainer $error_container): void
    {
        $this->getErrorContainer()->merge($error_container);
    }
}
