/**
 * Components: Card.
 *
 * @since 3.20.0
 */
import React from 'react';

const Card = ({
  show,
  title,
  icons,
  children
}) => (
  <figure className={'wl-card-' + show}>
    <figcaption>
      <h4>{title}</h4>
    </figcaption>
    {children}
  </figure>
);

export default Card;