---
title: Rules
parent: "How to use"
nav_order: 3
---

# Validate Brazilian Data With Laravel Rules
{: .no_toc }

1. TOC
{:toc}

## CpfRule

Validate a CPF number

Use in Validator Facade:

```php
use Illuminate\Support\Facades\Validator;
use SSolWEB\LaravelBrHelper\Rules\CpfRule;

$validator = Validator::make(
    ['cpf' => '529.982.247-25'],
    ['cpf' => ['required', new CpfRule()]]
);
```

Or in Form Requests:

```php
use Illuminate\Foundation\Http\FormRequest;
use SSolWEB\LaravelBrHelper\Rules\CpfRule;

class UserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'cpf' => ['required', new CpfRule()],
        ];
    }
}
```
