# GF fields for ACF: Gravity Forms Add-on in WPGraphQL

**Contributors:** Hardik Lakkad  
**Requires at least:** WordPress 5.5  
**Tested up to:** WordPress 6.2  
**Stable tag:** 1.0.0  
**License:** GPL-2.0+  
**License URI:** https://www.gnu.org/licenses/gpl-2.0.html  

## Description

This plugin integrates Gravity Forms, Advanced Custom Fields (ACF), and WPGraphQL, enabling you to select a Gravity Form in an ACF field type and query the selected form fields through WPGraphQL.

With this plugin, you can:
- Add a **Gravity Forms** field type in ACF fields.
- Query form fields of selected Gravity Forms through WPGraphQL.
- Enhance WPGraphQL schema compatibility with the `GfForm` field type.

## Screenshots

1. **Gravity Forms Field Type in ACF**  
   ![Gravity Forms Field Type](https://github.com/h-lakkad1998/wpgql-gf-form-in-acf/blob/main/assets/Add-Plugins-%E2%80%B9-Graphql-%E2%80%94-WordPress-10-26-2024_09_20_AM.png)

2. **Select Type As GfFOrm in ACF Setting Fields**  
   ![Gravity Forms Field Type](https://github.com/h-lakkad1998/wpgql-gf-form-in-acf/blob/main/assets/Add-Plugins-%E2%80%B9-Graphql-%E2%80%94-WordPress-10-26-2024_09_20_AM.png)
   
3. **Querying Form Fields via GraphQL**  
   ![GraphQL Query](https://github.com/h-lakkad1998/wpgql-gf-form-in-acf/blob/main/assets/GraphiQL-IDE-%E2%80%B9-Graphql-%E2%80%94-WordPress-10-26-2024_09_26_AM.png)

## Installation

1. Upload the plugin files to the `/wp-content/plugins/wpgql-gf-form-in-acf` directory or install via the WordPress plugins screen.
2. OR simply download the zip of the code and got add new plugin and upload the zip file.
3. Activate the plugin through the **Plugins** screen in WordPress.
4. Ensure both **WPGraphQL ACF** and **WPGraphQL Gravity Forms** plugins are active, as they are required dependencies.

## Requirements

- **WordPress**: 5.5 or higher
- **PHP**: 7.4 or higher
- **Plugins Required**:
  - [WPGraphQL ACF](https://github.com/wp-graphql/wpgraphql-acf)
  - [WPGraphQL Gravity Forms]( https://github.com/axewp/wp-graphql-gravity-forms/releases/latest/download/wp-graphql-gravity-forms.zip )

## Usage

1. After activation, you can register a post meta using ACF and select the **Gravity Form** field type to expose Gravity Form fields in WPGraphQL.
2. In your GraphQL queries, retrieve the form fields from the selected form in your ACF fields.

### Example GraphQL Query

```graphql
query NewQuery {
  posts {
    nodes {
      aToZedSettings {
        fieldGroupName
        gravityForm {
          formFields {
            nodes {
              inputType
              databaseId
              visibility
            }
          }
        }
      }
    }
  }
}
