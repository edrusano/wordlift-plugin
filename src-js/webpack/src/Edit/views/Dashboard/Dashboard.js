import React from 'react';
//import { Bar, Line } from 'react-chartjs-2';
import {
  Article,
  Section,
  Card
} from '../../components';

const Dashboard = () => (
  <Article type="dashboard">
    <Section>
      <Card title="Today's tip" text="The Apology of Socrates, by Plato">
      </Card>
    </Section>
  </Article>
);

const container = document.querySelector('#dashboard-container');
ReactDOM.render(React.createElement(Dashboard), container);
console.log(container);

export default Dashboard;
