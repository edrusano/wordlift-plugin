/**
 * Components: DefList.
 *
 * @since 3.20.0
 */
import React from 'react';

const DefList = ({
  show,
  stats,
  children
}) => (
  <dl>
  { children.map((stat, index) => (
    <React.Fragment>
    <dt key={index}>{stat.title}</dt>
    <dd>
      <em>{stat.value}</em>{ stat.max && 
      <span> / {stat.max}</span> }
    </dd>
    </React.Fragment>
  ))}
  </dl>
);

export default DefList;