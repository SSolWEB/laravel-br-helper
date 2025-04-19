<?php

namespace SSolWEB\LaravelBrHelper\Enums;

/**
 * Set the type of data to be saved in the database.
 */
enum DBType: string
{
    /** Save in database as string. */
    case STRING = 'string';
    /** Save in database as integer. */
    case INTEGER = 'integer';
    /** Save in database as formatted string. */
    case FORMATTED = 'formatted';
}
