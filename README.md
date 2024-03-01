# An extension to create blog posts for Shopware 6

An extension to _create blog posts_. The blog post is _created as a product_ and the blog list view as a _category_. The content of the blog post is controlled by a _product page layout_. In addition, the blog post is automatically found in the search and displayed in the search results.

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

#### tab "**Layout**"

- assigning a **product page layout** for the content of the blog post

#### tab "**SEO**"

- set **custom meta information** for the blog post if necessary, for example a custom **SEO path** to the blog post

#### tab "**Cross Selling**"

- assigning **assigned products** to the blog post

#### tab "**Reviews**"

- the **comment feature** for the blog post

### product page layout settings

- create a **product page layout** under "**Content**" and "**Shopping Experiences**"
- remove the cms block **Image gallery and buy box** 
- remove the cms block **Product description & reviews** if you don't need a rating function for the blog post
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

## Possible Configurations for the comment area on the blog post detail page
- set the text before the name of the author via snippet
- set the text of the tab via snippet
- set the text of the title of the teaser via snippet
- set the text of the title of the teaser if a comment has already been made via snippet
- set the text of the text of the teaser via snippet
- set the text of the text of the teaser if a comment has already been made via snippet
- set the text of the button to write a comment via snippet
- set the text of the button to edit a comment via snippet
- set the text of the button to show the comments via snippet
- set the text of the switch for displaying comments in the current language via snippet
- set the text of the description on the login form via snippet
- set the text of the link for new customers on the login form via snippet
- set the text of the label of the comment input field via snippet
- set the text of the success message after the comment has been submitted via snippet
- set the text of the success message after the comment has been changed via snippet
- set the text of the error message if the comment could not be saved via snippet
- set the text of the info message that the comment has not yet been approved via snippet
- set the text of the info message that there are no comments yet via snippet
- set the text before the author of a comment via snippet
- set the text before the date of a comment via snippet
- set the text before replying to a comment via snippet

## Available snippets
- sschreier.createblogposts.listing.boxProductDetails
- sschreier.createblogposts.detail.textBeforeManufacturerName
- sschreier.createblogposts.detail.tabsReview
- sschreier.createblogposts.detail.reviewTeaserTitle
- sschreier.createblogposts.detail.reviewExistsTeaserTitle
- sschreier.createblogposts.detail.reviewTeaserText
- sschreier.createblogposts.detail.reviewExistsTeaserText
- sschreier.createblogposts.detail.reviewTeaserButton
- sschreier.createblogposts.detail.reviewExistsTeaserButton
- sschreier.createblogposts.detail.reviewTeaserButtonHide
- sschreier.createblogposts.detail.reviewLanguageFilterLabel
- sschreier.createblogposts.detail.reviewLoginDescription
- sschreier.createblogposts.detail.reviewRegisterLink
- sschreier.createblogposts.detail.reviewFormContentLabel
- sschreier.createblogposts.detail.reviewFormSuccessAlert
- sschreier.createblogposts.detail.reviewFormSuccessUpdateAlert
- sschreier.createblogposts.detail.reviewFormErrorAlert
- sschreier.createblogposts.detail.reviewNotPublicYetAlert
- sschreier.createblogposts.detail.reviewListEmpty
- sschreier.createblogposts.detail.reviewItemAuthor
- sschreier.createblogposts.detail.reviewItemDate
- sschreier.createblogposts.detail.reviewCommentLabel

## How to install the extension
### via console (recommended)
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

2. Connect to the console via ssh and install the plugin source code via the command
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

### comment area on the blog post detail page

![comment area on the blog post detail page](https://www.sebastianschreier.de/plugins/SschreierCreateBlogPosts/SschreierCreateBlogPosts-Image3.jpg)

### comment area on the blog post detail page

![comment area on the blog post detail page](https://www.sebastianschreier.de/plugins/SschreierCreateBlogPosts/SschreierCreateBlogPosts-Image4.jpg)

### comment area on the blog post detail page

![comment area on the blog post detail page](https://www.sebastianschreier.de/plugins/SschreierCreateBlogPosts/SschreierCreateBlogPosts-Image5.jpg)

### comment area on the blog post detail page

![comment area on the blog post detail page](https://www.sebastianschreier.de/plugins/SschreierCreateBlogPosts/SschreierCreateBlogPosts-Image6.jpg)

### blog category without release dates and authors

![blog category](https://www.sebastianschreier.de/plugins/SschreierCreateBlogPosts/SschreierCreateBlogPosts-Image7.jpg)

### blog post detail page without release date and author

![blog post detail page](https://www.sebastianschreier.de/plugins/SschreierCreateBlogPosts/SschreierCreateBlogPosts-Image8.jpg)

### extension configuration part 1

![extension configuration part 1](https://www.sebastianschreier.de/plugins/SschreierCreateBlogPosts/SschreierCreateBlogPosts-Image9.jpg)

### extension configuration part 2

![extension configuration part 2](https://www.sebastianschreier.de/plugins/SschreierCreateBlogPosts/SschreierCreateBlogPosts-Image10.jpg)

### extension configuration part 3

![extension configuration part 3](https://www.sebastianschreier.de/plugins/SschreierCreateBlogPosts/SschreierCreateBlogPosts-Image11.jpg)

### extension configuration part 4

![extension configuration part 4](https://www.sebastianschreier.de/plugins/SschreierCreateBlogPosts/SschreierCreateBlogPosts-Image12.jpg)

### extension configuration part 5

![extension configuration part 5](https://www.sebastianschreier.de/plugins/SschreierCreateBlogPosts/SschreierCreateBlogPosts-Image13.jpg)

### extension configuration part 6

![extension configuration part 6](https://www.sebastianschreier.de/plugins/SschreierCreateBlogPosts/SschreierCreateBlogPosts-Image14.jpg)

### extension configuration part 7

![extension configuration part 7](https://www.sebastianschreier.de/plugins/SschreierCreateBlogPosts/SschreierCreateBlogPosts-Image15.jpg)

### extension configuration part 8

![extension configuration part 8](https://www.sebastianschreier.de/plugins/SschreierCreateBlogPosts/SschreierCreateBlogPosts-Image16.jpg)

### extension configuration part 9

![extension configuration part 9](https://www.sebastianschreier.de/plugins/SschreierCreateBlogPosts/SschreierCreateBlogPosts-Image17.jpg)

### category custom field in shopware administration

![category custom field in shopware administration](https://www.sebastianschreier.de/plugins/SschreierCreateBlogPosts/SschreierCreateBlogPosts-Image18.jpg)

### product custom field in shopware administration

![product custom field in shopware administration](https://www.sebastianschreier.de/plugins/SschreierCreateBlogPosts/SschreierCreateBlogPosts-Image19.jpg)
