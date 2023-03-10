<?php

namespace App\Http\Requests;

class QuoteUpdateRequest extends QuoteStoreRequest
{
	public function authorize()
	{
		return $this->quote->user_id === auth()->id();
	}

	public function rules()
	{
		$rules = parent::rules();
		$rules['image'] = ['nullable', 'image'];
		return $rules;
	}
}
