create view vcomment as
select c.id,c.title,c.description,c.url_image,c.user_id,s.name as user,p.title as product,p.slug,c.created_at,c.product_id,c.stakeholder_id
from comments c
JOIN users s ON s.id=c.user_id
left JOIN products p ON p.id=c.product_id


create or replace view vstakeholder as
        select s.id,s.name,s.address,s.phone,u.photo,s.user_id,count(p.id) as services,
        (select count(id) from stakeholder_like where stakeholder_id=s.id) as follower,s.subcategory_id,cat.slug 
        from stakeholders s
        join users u on u.id=s.user_id
        left join products p on p.supplier_id=s.id
        join categories as cat on cat.id=s.subcategory_id
        group by 1,2,3,4,5,cat.slug


drop view vusers

create or replace view vusers as 
select u.id,s.id as stakeholder_id,u.name,u.email,coalesce(u.photo,'') as photo,count(p.id) as services,
(select count(id) from stakeholder_like where user_id=u.id) as my_like,s."name" as artistic_name,s.description,u.token_google,coalesce(u.phone,'') as phone
from users u
left join stakeholders s on s.user_id=u.id
left join products p on p.supplier_id=s.id
group by 1,2,3,4

CREATE OR REPLACE VIEW public.vorders
as select o.id,
    o.date_service,
    o.restriction_alimentary as restriction,
    o.reason,
    o.address,
    o.client_id,
    u."name" as client,
    coalesce(u.photo,'') as photo_client,
    o.status_id,
    case when o.status_id=1 then 'Nuevo' when o.status_id=2 then 'Finalizado'  else 'Canelado' end status,
    s.name as supplier,
    sup.photo as photo_supplier,
    s.id as supplier_id,sum(det.quantity*det.price) subtotal
    from orders_detail det
    join orders o on o.id=det.order_id
    join products p on p.id=det.product_id
    join stakeholders s on s.id=p.supplier_id
    JOIN users sup ON sup.id = s.user_id
    JOIN users u ON u.id = o.client_id
    join stakeholders cli on cli.user_id=u.id
    group by 1,2,3,4,5,6,u.name,u.photo,sup.photo,s.name,s.id

  create view vorders_detail as
    select det.id,p.title as product,p.description, det.price,det.quantity,url_image,det.order_id
    from orders_detail det
    join products p on p.id=det.product_id


CREATE OR REPLACE VIEW public.vproducts
AS SELECT p.id,
    p.title,
    p.description,
    p.price,
    p.url_image,
    p.supplier_id,
    p.status_id,
    s.name AS supplier,
    u.photo
   FROM products p
     JOIN stakeholders s ON s.id = p.supplier_id
     JOIN users u ON u.id = s.user_id;

    insert into categories(title,url,level,node_id,slug,status_id) values('pizza','',3,5,'pizza',1)
    insert into categories(title,url,level,node_id,slug,status_id) values('burger','',3,5,'burguer',1)