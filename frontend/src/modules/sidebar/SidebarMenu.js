import React from "react";
import { Menu } from 'antd';
import { UserOutlined, AppstoreOutlined } from '@ant-design/icons';
import {Link} from "react-router-dom";

export default () => {
  const items = [
    {
      icon: AppstoreOutlined,
      label: (
        <Link to={'/admin/records'}>Записи</Link>
      )
    },
    {
      icon: UserOutlined,
      label: (
        <Link to={'/admin/users'}>Клиенты</Link>
      )
    },
  ];

  return (
    <Menu
      theme="dark"
      mode="inline"
      items={items.map(
        (item, index) => ({
          key: String(index + 1),
          icon: React.createElement(item.icon),
          label: item.label,
        }),
      )}
    />
  )
}