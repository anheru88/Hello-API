<?php

namespace App\Ship\Parents\Requests;

use App\Containers\Authorization\Traits\AuthorizationTrait;
use App\Ship\Engine\Traits\HashIdTrait;
use App\Ship\Features\Exceptions\ValidationFailedException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest as LaravelFormRequest;

/**
 * Class Request
 *
 * A.K.A (app/Http/Requests/Request.php)
 *
 * @author  Mahmoud Zalt  <mahmoud@zalt.me>
 */
abstract class Request extends LaravelFormRequest
{

    use HashIdTrait;
    use AuthorizationTrait;

    /**
     * Overriding this function to modify the any user input before
     * applying the validation rules.
     *
     * @return  array
     */
    public function all()
    {
        $requestData = parent::all();

        $requestData = $this->applyValidationRulesToUrlParams($requestData);

        $requestData = $this->decodeHashedIdsBeforeApplyingValidationRules($requestData);

        return $requestData;
    }

    /**
     * apply validation rules to the ID's in the URL, since Laravel
     * doesn't validate them by default!
     *
     * Now you can use validation riles like this: `'id' => 'required|integer|exists:items,id'`
     *
     * @param array $requestData
     *
     * @return  array
     */
    private function applyValidationRulesToUrlParams(Array $requestData)
    {
        if (isset($this->urlParameters) && !empty($this->urlParameters)) {
            foreach ($this->urlParameters as $param) {
                $requestData[$param] = $this->route($param);
            }
        }

        return $requestData;
    }

    /**
     * Overriding this function to throw a custom
     * exception instead of the default Laravel exception.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     *
     * @return mixed|void
     */
    public function failedValidation(Validator $validator)
    {
        throw new ValidationFailedException($validator->getMessageBag());
    }
}
