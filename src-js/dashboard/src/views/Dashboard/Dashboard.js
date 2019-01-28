/**
 * Views: Dashboard.
 *
 * @since 3.20.0
 */
import './Dashboard.scss';
import React from 'react';
import Card from './../../components/Card';
import DefList from './../../components/DefList';

const Dashboard = ({
  stats
}) => (
  <article class="wl-dashboard">
    <section>
      <Card show="news" title={stats.news.title}>
        {stats.news.value}
      </Card>
    </section>
    <section>
      <Card show="list" title={stats.keywords.title}>
        <DefList stats="{stats.keywords.value}">
          {stats.keywords.value}
        </DefList>
      </Card>
    </section>
  </article>
);

export default Dashboard;
