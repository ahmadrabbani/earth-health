<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocationAssessmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'location_name' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'radius_km' => 'required|numeric|min:0.1|max:25',
            'radius_m' => 'required|integer|min:100|max:25000',
            'urban_density' => 'nullable|in:high,medium,low',
        ];
    }

    protected function prepareForValidation(): void
    {
        $radiusKm = $this->input('radius_km');

        if ($radiusKm !== null && $radiusKm !== '') {
            $this->merge([
                'radius_m' => (int) round(((float) $radiusKm) * 1000),
            ]);
        }

        if (! $this->filled('urban_density')) {
            $this->merge([
                'urban_density' => 'medium',
            ]);
        }
    }

    public function messages(): array
    {
        return [
            'latitude.between' => 'Latitude must be between -90 and 90 degrees.',
            'longitude.between' => 'Longitude must be between -180 and 180 degrees.',
            'radius_km.min' => 'Coverage radius must be at least 0.1 kilometers.',
            'radius_km.max' => 'Coverage radius may not exceed 25 kilometers.',
            'radius_m.min' => 'Radius must be at least 100 meters.',
            'radius_m.max' => 'Radius may not exceed 25000 meters.',
            'urban_density.in' => 'Urban density must be high, medium, or low.',
        ];
    }
}
