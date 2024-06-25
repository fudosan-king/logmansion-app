class Catalog {
  final int id;
  final String title;
  final String description;
  final String image;
  final DateTime createdAt;
  final DateTime updatedAt;
  final String imageUrl;

  Catalog({
    required this.id,
    required this.title,
    required this.description,
    required this.image,
    required this.createdAt,
    required this.updatedAt,
    required this.imageUrl,
  });

  factory Catalog.empty() {
    return Catalog(
      id: 0,
      title: '',
      description: '',
      image: '',
      createdAt: DateTime.now(),
      updatedAt: DateTime.now(),
      imageUrl: '',
    );
  }

  factory Catalog.fromJson(Map<String, dynamic> json) {
    return Catalog(
      id: json['cata_id'] ?? 0,
      title: json['cata_title'] ?? '',
      description: json['cata_description'] ?? '',
      image: json['cata_image'] ?? '',
      createdAt: DateTime.parse(json['created_at'] ?? DateTime.now().toString()),
      updatedAt: DateTime.parse(json['updated_at'] ?? DateTime.now().toString()),
      imageUrl: json['cata_image_url'] ?? '',
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'cata_id': id,
      'cata_title': title,
      'cata_description': description,
      'cata_image': image,
      'created_at': createdAt.toIso8601String(),
      'updated_at': updatedAt.toIso8601String(),
      'cata_image_url': imageUrl,
    };
  }
}
