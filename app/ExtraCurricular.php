<?php

namespace App;

enum ExtraCurricular: string
{
    case international = 'international';
    case national = 'national';
    case university = 'university';
    case journalism = 'journalism';
    case bncc = 'bncc';
    case roverscout = 'roverscout';

    public function certificateField(): string
    {
        return match ($this) {
            self::international => 'international_certificate',
            self::national => 'national_certificate',
            self::university => 'university_certificate',
            self::journalism => 'journalism_certificate',
            self::bncc => 'bncc_certificate',
            self::roverscout => 'roverscout_certificate',
        };
    }

    public function pathField(): string
    {
        return match ($this) {
            self::international => 'international_certificate_path',
            self::national => 'national_certificate_path',
            self::university => 'university_certificate_path',
            self::journalism => 'journalism_certificate_path',
            self::bncc => 'bncc_certificate_path',
            self::roverscout => 'roverscout_certificate_path',
        };
    }

    public function displayName(): string
    {
        return match ($this) {
            self::international => 'International Level Certificate/Medal',
            self::national => 'National Level Certificate/Medal',
            self::university => 'University Level Certificate/Medal',
            self::journalism => 'Journalism Certificate',
            self::bncc => 'BNCC Certificate',
            self::roverscout => 'Rover Scout Certificate',
        };
    }
}
