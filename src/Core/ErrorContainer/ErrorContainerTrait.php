<?php

namespace Core\ErrorContainer;

trait ErrorContainerTrait
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

    public function getErrors(): array
    {
        return $this->getErrorContainer()->getErrors(ErrorContainer::FORMAT_PLAIN);
    }

    public function getError($attribute): ?string
    {
        return $this->getErrorContainer()->getError($attribute);
    }

    public function addError(string $attribute, string $error, $object_id = null): self
    {
        $this->getErrorContainer()->addError($attribute, $error, $object_id);
        return $this;
    }

    public function addErrors(array $errors): self
    {
        $this->getErrorContainer()->addErrors($errors);
        return $this;
    }

    public function clearErrors(): void
    {
        $this->getErrorContainer()->clearErrors();
    }

    public function mergeErrors(ErrorContainer $error_container): void
    {
        $this->getErrorContainer()->merge($error_container);
    }
}
