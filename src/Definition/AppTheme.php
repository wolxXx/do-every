<?php

declare(strict_types = 1);

namespace DoEveryApp\Definition;

enum AppTheme: string
{
    case DEFAULT    = 'default';

    case BLUE       = 'blue';

    case RED        = 'red';

    case GREEN      = 'green';

    case LIGHT      = 'light';

    case PINK       = 'pink';

    case YELLOW     = 'yellow';

    case ORANGE     = 'orange';

    case LIGHT_GRAY = 'light-gray';

    case DARK_GRAY  = 'dark-gray';
}
