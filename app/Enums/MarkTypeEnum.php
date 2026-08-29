<?php

namespace App\Enums;

enum MarkTypeEnum: string
{
    case MetadataMismatch = 'metadata_mismatch';
    case LowAudioQuality = 'low_audio_quality';
    case Other = 'other';
}
