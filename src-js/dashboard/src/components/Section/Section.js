/**
 * Components: Section.
 *
 * @since 3.21.0
 */

import React from 'react';

const Section = ({
  type,
  children
}) => (
  <section className="{type}">{children}</section>
);

export default Section;