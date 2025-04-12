# An extension to create blog posts for Shopware 6

An extension to _create blog posts_. The blog post is _created as a product_ and the blog list view as a _category_. The content of the blog post is controlled by a _product page layout_. In addition, the blog post is automatically found in the search and displayed in the search results. An _rss feed_ is located at the path `/rss`, so under `http://your-domain.de/rss`.

## how to use it

### blog category settings

- create a category under "**Catalogues**" and "**Categories**"
- switch to the area "**Custom fields**" of the tab "**General**"
- activate the checkbox "**is a blog post category**" in the area "**blog post settings**"

#### use custom sorting

- switch to the area "**Category listing**" of the tab "**Layout**"
- activate the switch "**Use custom sortings**" in the tab "**Sorting**"
- remove unnecessary sortings 
- **tip:** create a sorting based on the _product release date_

#### disabling the filters you don't need

- switch to the area "**Category listing**" of the tab "**Layout**"
- deactivate the switch "**Filter by manufacturer**" in the tab "**Filter**"
- deactivate the switch "**Filter by rating**" in the tab "**Filter**"
- deactivate the switch "**Filter by price**" in the tab "**Filter**"
- deactivate the switch "**Filter for free shipping**" in the tab "**Filter**"
- **tip:** 
  - create a property for the _author_ and use it for a filter
  - create a property for _tags_ and use it for a filter

### author settings

- create an author under "**Catalogues**" and "**Manufacturers**" if you want to display authors

### blog post settings

#### tab "**General**"

- set the title of the blog post in the field "**Name**" in the area "**General information**"
- select the author of the blog post at the field "**Manufacturer**" in the area "**General information**" if you want to display the author
- set the teaser of the blog post for the category listing in the field "**Description**" in the area "**General information**"
- set the value of the fields "**Price (gross)**" and "**Price (net)**" to **0** in the area "**Prices**"
- set the value of the field "**Stock**" to **0** and activate the switch "**Clearance sale**" in the area "**Deliverability**"
- select the blog category at the field "**Categories**" in the area "**Visibility & structure**"
- select the teaser image at the field "**Cover**" in the area "**Media**"
- set the release date of the blog post in the field "**Release date**" in the area "**Labelling**" if you want to display the release date

#### tab "**Specifications**"

- add properties to the blog post in the area "**Properties**" to filter by them, such as the author, a tag or the month and year of the release date
- switch to the "**Custom fields**" area of the tab "**Specifications**"
- activate the checkbox "**is a blog post**" in the area "**blog post settings**"
- activate the checkbox "**show in rss feed**" in the area "**blog post settings**"

#### tab "**Layout**"

- assigning a **product page layout** for the content of the blog post

#### tab "**SEO**"

- set **custom meta information** for the blog post if necessary, for example a custom **SEO path** to the blog post

#### tab "**Cross Selling**"

- assigning **assigned products** to the blog post

### product page layout settings

- create a **product page layout** under "**Content**" and "**Shopping Experiences**"
- remove the cms block **Image gallery and buy box** 
- remove the cms block **Product description & reviews**
- remove the cms block **Cross Selling** if you don't want to display assigned products

#### example 1: all images assigned to the blog post are displayed in an image gallery, followed by the content of the blog post, which is located in the field "Description"

- select the cms element "**Image gallery**" from the block category "**Images**"
- in the tab "**Image gallery**", select "**product.media**" under "**Data mapping**"
- select the cms element "**Text**" from the block category "**Text**"
- in the tab "**Content**", select "**product.description**" under "**Data mapping**"

#### example 2: the content of the blog post is maintained completely via the CMS

- add cms elements with text and images

## Possible Configurations for the blog list view
- select the number of side by side product boxes in mobile view
- select the number of side by side product boxes in tablet view
- select the number of side by side product boxes in desktop view
- select the release date format
- set the text of the read more button for the blog posts via snippet
- select, if the teaser images of the blog posts should be shown
- set the background color of the area that will be displayed if no teaser image has been assigned
- set the opacity value of the background color of the area that will be displayed if no teaser image has been assigned
- select the alignment of the content of the area that will be displayed if no teaser image has been assigned
- set the padding value in pixels of the area that will be displayed if no teaser image has been assigned
- set the color of the headline in the area that will be displayed if no teaser image has been assigned
- set the font size of the headline in the area that will be displayed if no teaser image has been assigned
- set the line height of the headline in the area that will be displayed if no teaser image has been assigned
- set the color of the text in the area that will be displayed if no teaser image has been assigned
- set the font size of the text in the area that will be displayed if no teaser image has been assigned
- set the line height of the text in the area that will be displayed if no teaser image has been assigned
- set the number of lines from which the text will be truncated

## Possible Configurations for the search results
- select, if the read more button for the blog posts should be shown

## Possible Configurations for the blog post detail page
- select the release date format
- set the text before the name of the author via snippet

## Possible Configurations for the rss feed
- set a custom url of the blog post category
- set a custom language abbreviation
- set the title of the rss feed via snippet
- set the description of the rss feed via snippet
- set the copyright notice of the rss feed via snippet
- set the number of characters from which the description of a blog post should be truncated

## Available snippets
- sschreier.createblogposts.listing.boxProductDetails
- sschreier.createblogposts.detail.textBeforeManufacturerName
- sschreier.createblogposts.rssfeed.title
- sschreier.createblogposts.rssfeed.description
- sschreier.createblogposts.rssfeed.copyright

## How to install the extension
### via zip and console (recommended)
1. Download the latest _SschreierCreateBlogPosts-master.zip_.
2. Unzip the zip file and rename the folder to _SschreierCreateBlogPosts_.
3. Move the folder to the project folder _custom/plugins/_ .
4. Connect to the console via ssh:

```
bin/console plugin:refresh
bin/console plugin:install --activate SschreierCreateBlogPosts
```

### via composer
1. Add the repository URL to the composer.json of the project
```
"repositories": [
    ...,
    {
        "type": "vcs",
        "url": "https://github.com/sschreier/SschreierCreateBlogPosts"
    }
],
```

2. Connect to the console via ssh and install the plugin via the command
```
composer require sschreier/sschreiercreateblogposts
bin/console plugin:refresh
bin/console plugin:install --activate SschreierCreateBlogPosts
```

### via https://packagist.org
 - Connect to the console via ssh and install the plugin via the command

```
composer require sschreier/sschreiercreateblogposts
bin/console plugin:refresh
bin/console plugin:install --activate SschreierCreateBlogPosts
```

### via zip upload
1. Download the latest _SschreierCreateBlogPosts-master.zip_.
2. Unzip the zip file and rename the folder to _SschreierCreateBlogPosts_.
3. Zip the folder to _SschreierCreateBlogPosts.zip_.
4. Upload the zip in the Shopware Administration.
5. Install & Activate the extension.

#### extension update (zip)
1. Download the latest _SschreierCreateBlogPosts-master.zip_.
2. Unzip the zip file and rename the folder to _SschreierCreateBlogPosts_.
3. Zip the folder to _SschreierCreateBlogPosts.zip_.
4. Upload the zip in the Shopware Administration.
5. Update the extension.

## Images

### blog category without teaser images

![blog category](https://www.sebastianschreier.de/plugins/SschreierCreateBlogPosts/SschreierCreateBlogPosts-Image1.jpg)

### blog post detail page

![blog post detail page](https://www.sebastianschreier.de/plugins/SschreierCreateBlogPosts/SschreierCreateBlogPosts-Image2.jpg)

### blog category without release dates and authors

![blog category](https://www.sebastianschreier.de/plugins/SschreierCreateBlogPosts/SschreierCreateBlogPosts-Image3.jpg)

### blog post detail page without release date and author

![blog post detail page](https://www.sebastianschreier.de/plugins/SschreierCreateBlogPosts/SschreierCreateBlogPosts-Image4.jpg)

### extension configuration part 1

![extension configuration part 1](https://www.sebastianschreier.de/plugins/SschreierCreateBlogPosts/SschreierCreateBlogPosts-Image5.jpg)

### extension configuration part 2

![extension configuration part 2](https://www.sebastianschreier.de/plugins/SschreierCreateBlogPosts/SschreierCreateBlogPosts-Image6.jpg)

### extension configuration part 3

![extension configuration part 3](https://www.sebastianschreier.de/plugins/SschreierCreateBlogPosts/SschreierCreateBlogPosts-Image7.jpg)

### extension configuration part 4

![extension configuration part 4](https://www.sebastianschreier.de/plugins/SschreierCreateBlogPosts/SschreierCreateBlogPosts-Image8.jpg)

### extension configuration part 5

![extension configuration part 5](https://www.sebastianschreier.de/plugins/SschreierCreateBlogPosts/SschreierCreateBlogPosts-Image9.jpg)

### extension configuration part 6

![extension configuration part 6](https://www.sebastianschreier.de/plugins/SschreierCreateBlogPosts/SschreierCreateBlogPosts-Image10.jpg)

### extension configuration part 7

![extension configuration part 7](https://www.sebastianschreier.de/plugins/SschreierCreateBlogPosts/SschreierCreateBlogPosts-Image11.jpg)

### category custom field in shopware administration

![category custom field in shopware administration](https://www.sebastianschreier.de/plugins/SschreierCreateBlogPosts/SschreierCreateBlogPosts-Image12.jpg)

### product custom field in shopware administration

![product custom field in shopware administration](https://www.sebastianschreier.de/plugins/SschreierCreateBlogPosts/SschreierCreateBlogPosts-Image13.jpg)
