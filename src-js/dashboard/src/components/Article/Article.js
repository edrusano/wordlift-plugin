/**
 * Components: Article.
 *
 * @since 3.21.0
 */

import React from 'react';

const Article = (props) => (
  <article className="{props.belongsTo}">
    {props.children}
  </article>
);

export default Article;