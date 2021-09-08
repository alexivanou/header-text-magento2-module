# BelVG_Tools
is Magento 2 Module for adding H1 text block into all shop pages.

## Install

```bash
cd <magento2-dir>
mkdir -p app/code/BelVG/Tools
git clone https://github.com/alexivanou/header-text-magento2-module app/code/BelVG/Tools
bin/magento module:enable BelVG_Tools
bin/magento cache:clean && bin/magento setup:upgrade && bin/magento setup:di:compile
```

## Using

### Setting Header Text

```bash
<magento2-dir>:$> bin/magento belvg:set_header_text "Some Text"
```

### Deleting Header Text

```bash
<magento2-dir>:$> bin/magento belvg:set_header_text ""
```
