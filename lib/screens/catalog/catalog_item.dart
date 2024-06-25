import 'package:flutter/material.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';

import '../../models/catalog.dart';

class CatalogItem extends StatelessWidget {
  final Catalog catalog;

  const CatalogItem({
    super.key,
    required this.catalog,
  });

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.only(bottom: 30),
      child: Column(
        mainAxisSize: MainAxisSize.min,
        mainAxisAlignment: MainAxisAlignment.start,
        crossAxisAlignment: CrossAxisAlignment.center,
        children: [
          Container(
            width: 335.w,
            height: 236.h,
            decoration: BoxDecoration(
              image: DecorationImage(
                image: NetworkImage(catalog.imageUrl),
                fit: BoxFit.fitWidth,
              ),
            ),
          ),
          SizedBox(
            width: double.infinity,
            child: Column(
              mainAxisSize: MainAxisSize.min,
              mainAxisAlignment: MainAxisAlignment.start,
              crossAxisAlignment: CrossAxisAlignment.center,
              children: [
                const SizedBox(height: 8),
                SizedBox(
                  width: double.infinity,
                  child: Text(
                    catalog.title,
                    style: TextStyle(
                      color: Color(0xFF101928),
                      fontSize: 16,
                      fontFamily: 'SF Pro Display',
                      fontWeight: FontWeight.w700,
                      // height: 0,
                    ),
                  ),
                ),
                const SizedBox(height: 8),
                SizedBox(
                  width: double.infinity,
                  child: Text(
                    catalog.description,
                    style: TextStyle(
                      color: Color(0xFF101928),
                      fontSize: 12,
                      fontFamily: 'SF Pro Display',
                      fontWeight: FontWeight.w400,
                      // height: 0.13,
                    ),
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }
}