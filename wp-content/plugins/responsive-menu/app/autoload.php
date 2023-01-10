<?php

/*
|--------------------------------------------------------------------------
| Autoload our application
|--------------------------------------------------------------------------
|
| Here we include all our required files for the application to run correctly.
| At the moment this is a big mess of require_once calls and needs to be 
| tidied up with an autoloader function
|
*/

require_once 'library/responsive-menu/Registry.php';

require_once 'config.php';

require_once 'library/responsive-menu/ResponsiveMenu.php';

require_once 'library/responsive-menu/View.php';

require_once 'library/responsive-menu/Status.php';

require_once 'library/responsive-menu/Input.php';

require_once 'controllers/BaseController.php';

require_once 'controllers/AdminController.php';

require_once 'controllers/FrontController.php';

require_once 'controllers/GlobalController.php';

require_once 'controllers/InstallController.php';

require_once 'controllers/HTMLController.php';

require_once 'controllers/JSController.php';

require_once 'controllers/CSSController.php';

require_once 'controllers/UpgradeController.php';

require_once 'models/BaseModel.php';

require_once 'models/AdminModel.php';

require_once 'models/FolderModel.php';

require_once 'models/CSSModel.php';

require_once 'models/JSModel.php';