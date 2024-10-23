# MethorZ MarkMe

MethorZ MarkMe is a powerful and flexible Markdown parser library for PHP. It allows you to convert Markdown text into HTML with ease.

## Features

- **Markdown Parsing**: Convert Markdown text to HTML.
- **Custom Renderers**: Extend and customize the rendering of Markdown elements.
- **PHP 8.3**: Fully compatible with PHP 8.3.

## Installation

You can install the package via Composer:

```bash
composer require methorz/markme
```

Usage
Here's a basic example of how to use the MarkMe library:

```bash
<?php

require 'vendor/autoload.php';

use MethorZ\MarkMe\Markdown;
use MethorZ\MarkMe\Renderer\ParagraphRenderer;
use MethorZ\MarkMe\Element\Paragraph;
use MethorZ\MarkMe\Element\Text;

$markdown = new Markdown();
$markdown->setRenderer(Paragraph::class, new ParagraphRenderer());

$text = new Text('This is a paragraph.');
$paragraph = new Paragraph($text);

echo $markdown->render($paragraph);
```

Custom Renderers
You can create custom renderers for different Markdown elements. Here's an example of a custom renderer for a horizontal rule:

```bash
<?php

namespace MethorZ\MarkMe\Renderer;

use MethorZ\MarkMe\Element\HorizontalRule;

class HorizontalRuleRenderer
{
    public function render(HorizontalRule $element): string
    {
        return '<hr />';
    }
}
```

## Contributing
Contributions are welcome! Please submit a pull request or open an issue to discuss your ideas.  

## License
This project is licensed under the proprietary license. See the LICENSE file for more details.  

## Contact
For any inquiries, please contact MethorZ at methorz@spammerz.de.
