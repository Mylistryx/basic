<?php

declare(strict_types=1);

namespace app\components\Forms;

use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Class CompositeForm
 */
abstract class CompositeForm extends Model
{
    /**
     * @var Model[]|array[]
     */
    protected array $innerForms = [];

    /**
     * @return array of internal forms like ['meta', 'values']
     */
    abstract protected function internalForms(): array;

    public function load($data, $formName = null): bool
    {
        $success = parent::load($data, $formName);
        foreach ($this->innerForms as $name => $form) {
            if (is_array($form)) {
                $success = Model::loadMultiple($form, $data, $formName === null ? null : $name) || $success;
            } else {
                $success = $form->load($data, $formName !== '' ? null : $name) || $success;
            }
        }
        return $success;
    }

    public function validate($attributeNames = null, $clearErrors = true): bool
    {
        if ($attributeNames !== null) {
            $parentNames = array_filter($attributeNames, 'is_string');
            $success = !$parentNames || parent::validate($parentNames, $clearErrors);
        } else {
            $success = parent::validate(null, $clearErrors);
        }
        foreach ($this->innerForms as $name => $form) {
            if ($attributeNames === null || array_key_exists($name, $attributeNames) || in_array($name, $attributeNames, true)) {
                $innerNames = ArrayHelper::getValue($attributeNames, $name);
                if (is_array($form)) {
                    $success = Model::validateMultiple($form, $innerNames) && $success;
                } else {
                    $success = $form->validate($innerNames, $clearErrors) && $success;
                }
            }
        }
        return $success;
    }


    /**
     * @param string|null $attribute
     * @return bool
     */
    public function hasErrors(?string $attribute = null): bool
    {
        if ($attribute !== null && mb_strpos($attribute, '.') === false) {
            return parent::hasErrors($attribute);
        }
        if (parent::hasErrors($attribute)) {
            return true;
        }
        foreach ($this->innerForms as $name => $form) {
            if (is_array($form)) {
                foreach ($form as $i => $item) {
                    if ($attribute === null) {
                        if ($item->hasErrors()) {
                            return true;
                        }
                    } elseif (mb_strpos($attribute, $name . '.' . $i . '.') === 0) {
                        if ($item->hasErrors(mb_substr($attribute, mb_strlen($name . '.' . $i . '.')))) {
                            return true;
                        }
                    }
                }
            } else {
                if ($attribute === null) {
                    if ($form->hasErrors()) {
                        return true;
                    }
                } elseif (mb_strpos($attribute, $name . '.') === 0) {
                    if ($form->hasErrors(mb_substr($attribute, mb_strlen($name . '.')))) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    /**
     * @param string|null $attribute
     * @return array
     */
    public function getErrors(?string $attribute = null): array
    {
        $result = parent::getErrors($attribute);
        foreach ($this->innerForms as $name => $form) {
            if (is_array($form)) {
                /** @var Model[] $form */
                foreach ($form as $i => $item) {
                    foreach ($item->getErrors() as $attr => $errors) {
                        /** @var array $errors */
                        $errorAttr = $name . '.' . $i . '.' . $attr;
                        if ($attribute === null) {
                            foreach ($errors as $error) {
                                $result[$errorAttr][] = $error;
                            }
                        } elseif ($errorAttr === $attribute) {
                            foreach ($errors as $error) {
                                $result[] = $error;
                            }
                        }
                    }
                }
            } else {
                foreach ($form->getErrors() as $attr => $errors) {
                    /** @var array $errors */
                    $errorAttr = $name . '.' . $attr;
                    if ($attribute === null) {
                        foreach ($errors as $error) {
                            $result[$errorAttr][] = $error;
                        }
                    } elseif ($errorAttr === $attribute) {
                        foreach ($errors as $error) {
                            $result[] = $error;
                        }
                    }
                }
            }
        }
        return $result;
    }

    /**
     * @return array
     */
    public function getFirstErrors(): array
    {
        $result = parent::getFirstErrors();
        foreach ($this->innerForms as $name => $form) {
            if (is_array($form)) {
                foreach ($form as $i => $item) {
                    foreach ($item->getFirstErrors() as $attr => $error) {
                        $result[$name . '.' . $i . '.' . $attr] = $error;
                    }
                }
            } else {
                foreach ($form->getFirstErrors() as $attr => $error) {
                    $result[$name . '.' . $attr] = $error;
                }
            }
        }
        return $result;
    }

    public function __get($name)
    {
        if (isset($this->innerForms[$name])) {
            return $this->innerForms[$name];
        }
        return parent::__get($name);
    }

    public function __set($name, $value)
    {
        if (in_array($name, $this->internalForms(), true)) {
            $this->innerForms[$name] = $value;
        } else {
            parent::__set($name, $value);
        }
    }

    public function __isset($name)
    {
        return isset($this->innerForms[$name]) || parent::__isset($name);
    }
}